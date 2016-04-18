<?php

namespace xShop;

class Model_Invoice extends \Model_Document{
	public $table = 'xshop_invoices';
	public $status  = array('draft','submitted','approved','canceled','completed','processed');
	public $root_document_name = 'xShop\Invoice';

	public $actions=array(
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_send_via_email'=>array(),
		);

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->hasOne('xShop/OrderDetails','orderitem_id')->sortable(true);
		$this->hasOne('xShop/Customer','customer_id')->display(array('form'=>'autocomplete/Basic'))->caption('Customers')->sortable(true);
		$this->hasOne('xPurchase/Supplier','supplier_id')->sortable(true);
		$this->hasOne('xShop/Model_Order','sales_order_id');
		$this->hasOne('xPurchase/Model_PurchaseOrder','po_id')->caption('Purchase Order');
		$this->hasOne('xShop/TermsAndCondition','termsandcondition_id')->display(array('form'=>'autocomplete/Basic'))->caption('Terms & Cond.');
		$this->hasOne('xShop/Currency','currency_id')->sortable(true)->mandatory(true)->mandatory(true);

		$this->addField('type')->enum(array('salesInvoice','purchaseInvoice'));
		$this->addField('name')->caption('Invoice No')->type('int')->sortable(true);
		$this->addField('total_amount')->type('money');
		$this->addField('gross_amount')->type('money')->sortable(true);
		$this->addField('discount')->type('money');
		$this->addField('tax')->type('money');
		$this->addField('net_amount')->type('money');
		$this->addField('shipping_charge')->type('money');
		$this->addField('billing_address')->type('text');
		$this->addField('transaction_reference')->type('text');
		$this->addField('transaction_response_data')->type('text');
		$this->addField('narration')->type('text');
		
		$this->addHook('beforeDelete',$this);
		$this->addHook('beforeSave',$this);
		$this->addHook('afterSave',$this);
		
		$this->hasMany('xShop/InvoiceItem','invoice_id');
		$this->setOrder('updated_at','desc');

		$this->addExpression('shipping_charge')->set(function($m,$q){
			return $m->refSQL('xShop/InvoiceItem')->sum('shipping_charge');
		});

		$this->add('dynamic_model/Controller_AutoCreator');
	}
	
	function afterSave(){
		$this->updateAmounts();

		// TODO UPdate Transaction entry as well if any
		if($tr= $this->transaction()){
			$tr->forceDelete();
			$this->createVoucher();
		}
	}

	function termAndCondition(){
		return $this->ref('termsandcondition_id');
	}

	function transaction(){
		$tr = $this->add('xAccount/Model_Transaction')->loadWhoseRelatedDocIs($this);
		if($tr and $tr->loaded()) return $tr;
		return false;
	}
	
	function updateAmounts(){
		
		$shop_config = $this->add('xShop/Model_Configuration')->tryLoadAny();

		$this['total_amount']=0;
		$this['gross_amount']=0;
		$this['tax']=0;
		$this['net_amount']=0;
		
		$invoice_items_info = "";
		foreach ($this->itemrows() as $oi) {
			$this['total_amount'] = $this['total_amount'] + $oi['amount'];
			$this['gross_amount'] = $this['gross_amount'] + ($oi['texted_amount']?:0);
			$this['tax'] = $this['tax'] + $oi['tax_amount'];					
			$invoice_items_info .= 	$oi->item()->get('name')." ".
									$oi['amount']." ".
									$oi['qty']." ".
									$oi['narration']." ".
									$oi->item()->get('item_name');
		}	
		
		$this['net_amount'] = $this['total_amount'] + $this['tax'] - $this['discount'] + ($this['shipping_charge']?$this['shipping_charge']:0);
		//xShop Configuration model must be loaded in Api
		$shop_config = $this->add('xShop/Model_Configuration')->tryLoadAny();
		if($shop_config['is_round_amount_calculation']){
			$this['net_amount'] = round($this['net_amount'],0);
		}
		
		//Updating Search String		
		$str = 	$this['name']." ".
				$this['type']. " ".
				$this['total_amount']." ".
				$this['net_amount']. " ".
				$this['narration']. " ".
				$this['shipping_address']. " ".
				$this['billing_address']. " ".
				$this['order_summary']. "".
				$invoice_items_info;
				
		$str .= $this['customer_id']?$this->ref('customer_id')->get('name'):"";
		$str .= $this['sales_order_id']?$this->order()->get('search_phrase'):"";
		$str .= $this['supplier_id']?$this->ref('supplier_id')->get('name'):"";
		$str .= $this['po_id']?$this->order()->get('name'):"";

		$this['search_string'] = $str;
		$this->save();
		
	}

	function beforeSave(){
		if($this['customer'] and $this['supplier'])
			throw $this->Exception('Select Either Customer or Supplier','ValidityCheck')->setField('customer_id');
		
		if($this['sales_order'] and $this['po'])
			throw $this->Exception('Select Either Sales Order or Purchase Order','ValidityCheck')->setField('sales_order_id');

		if(!$this['name']){
			$this['name'] = $this->getNextSeriesNumber($this->add('xShop/Model_Configuration')->tryLoadAny()->get('sale_invoice_starting_number'));
		}
	}


	function beforeDelete(){
		$this->ref('xShop/InvoiceItem')->each(function($obj){$obj->forceDelete();});
	}

	function netAmount(){
		return $this['net_amount'];
	}

	function discount(){
		return $this['discount'];
	}

	function tax(){
		return $this['tax'];
	}

	function itemrows(){
		return $this->ref('xShop/InvoiceItem');
	}
	
	function isApproved(){
		if(!$this->loaded())
			return false;
		
		$this->addCondition('status','<>','submitted');
		$this->addCondition('status','<>','draft');
		$this->tryLoadAny();
		return $this;
	}

	function addItem($item,$qty,$rate,$amount,$unit,$narration,$custom_fields,$apply_tax=0,$tax_id=0,$shipping_charge=0){
		$in_item = $this->ref('xShop/InvoiceItem');
		$in_item['item_id'] = $item->id;
		$in_item['qty'] = $qty;
		$in_item['rate'] = $rate;
		$in_item['amount'] = $amount;
		$in_item['unit'] = $unit;
		$in_item['narration'] = $narration;
		$in_item['custom_fields'] = $custom_fields;
		$in_item['apply_tax'] = $apply_tax;
		$in_item['tax_id'] = $tax_id;
		$in_item['shipping_charge'] = $shipping_charge;
		$in_item->save();
	}
	
	function itemsTermAndCondition(){
		$tnc = "";
		$item_array = array();
		foreach ($this->itemRows() as $q_item) {
			$item = $q_item->item();
			if(in_array($item->id, $item_array)) continue;

			$tnc .= $item['terms_condition'];
			$item_array[]=$item->id;
		}

		return $tnc;
		
	}

	function parseEmailBody(){

		$view=$this->add('xShop/View_SalesInvoiceDetail');
		$view->setModel($this->itemrows());
		
		$tnc = $this->termAndCondition();
		$tnc = $tnc['terms_and_condition'].$this->itemsTermAndCondition();

		$customer = $this->customer();
		$customer_email=$customer->get('customer_email');

		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
				
		$email_body=$config_model['invoice_email_body']?:"Invoice Layout Is Empty";
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$email_body = str_replace("{{customer_name}}", $customer['customer_name'], $email_body);
		$email_body = str_replace("{{customer_organization_name}}", $customer['organization_name'], $email_body);
		$email_body = str_replace("{{customer_billing_address}}", $customer['billing_address']?$customer['billing_address']:"", $email_body);
		$email_body = str_replace("{{mobile_number}}", $customer['mobile_number']?$customer['mobile_number']:" ", $email_body);
		$email_body = str_replace("{{city}}", $customer['city']?$customer['city']:" ", $email_body);
		$email_body = str_replace("{{state}}", $customer['state']?$customer['state']:" ", $email_body);
		$email_body = str_replace("{{country}}", $customer['country']?$customer['country']:" ", $email_body);
		$email_body = str_replace("{{order_billing_address}}",$customer['billing_address']?$customer['billing_address']:" ", $email_body);
		$email_body = str_replace("{{order_shipping_address}}",$customer['shipping_address']?$customer['shipping_address']:" ", $email_body);
		$email_body = str_replace("{{customer_email}}", $customer['customer_email']?$customer['customer_email']:" ", $email_body);
		$email_body = str_replace("{{customer_tin_no}}", $customer['tin_no']?$customer['tin_no']:" - ", $email_body);
		$email_body = str_replace("{{customer_pan_no}}", $customer['pan_no']?$customer['pan_no']:" - ", $email_body);
		$email_body = str_replace("{{invoice_details}}", $view->getHtml(), $email_body);
		$email_body = str_replace("{{invoice_no}}", $this['name'], $email_body);
		$email_body = str_replace("{{invoice_date}}",$this->customDateFormat(), $email_body);
		$email_body = str_replace("{{invoice_order_no}}", $this->order()->get('name'), $email_body);
		$email_body = str_replace("{{order_invoice_date}}", $this->order()->get('created_at'), $email_body);
		$email_body = str_replace("{{delivery_note}}", $this->order()->deliveryNotes()->get('name'), $email_body);
		$email_body = str_replace("{{dispatch_challan_no}}", "", $email_body);
		$email_body = str_replace("{{dispatch_challan_date}}","", $email_body);
		$email_body = str_replace("{{terms_an_conditions}}", $tnc?$tnc:"", $email_body);
		$email_body = str_replace("{{invoice_narration}}",$this['narration'], $email_body);

		return $email_body;
	}

	function send_via_email_page($p){

		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');
		
		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();

		$customer = $this->customer();
		$customer_email=$customer->get('customer_email');

		$emails = explode(',', $customer['customer_email']);
		$email_body = $this->parseEmailBody();

		$form = $p->add('Form_Stacked');
		$form->addField('line','to')->set($emails[0]);
		// array_pop(array_re/verse($emails));
		unset($emails[0]);

		$form->addField('line','cc')->set(implode(',',$emails));
		$form->addField('line','bcc');
		$form->addField('line','subject')->validateNotNull()->set($config_model['invoice_email_subject']);
		$form->addField('RichText','custom_message');
		$form->add('View')->setHTML($email_body);
		$form->addSubmit('Send');
		if($form->isSubmitted()){

			$ccs=$bccs = array();
			if($form['cc'])
				$ccs = explode(',',$form['cc']);

			if($form['bcc'])
				$bccs = explode(',',$form['bcc']);
			
			$subject = $this->emailSubjectPrefix($form['subject']);
			$email_body = $form['custom_message']."<br>".$email_body;
			$this->sendEmail($form['to'],$subject,$email_body,$ccs,$bccs);
			$this->createActivity('email',$subject,$form['message'],$from=null,$from_id=null, $to='Customer', $to_id=$customer->id);
			return true;			
		}
		
	}

	function reject_page($page){
		$form= $page->add('Form_Stacked');
		$form->addField('text','reason');
		$form->addSubmit('Reject & Send to Re Design');
		if($form->isSubmitted()){
			$this->setStatus('redesign',$form['reason']);
			return true;
		}
	}

	function order(){
		return $this->ref('sales_order_id');
	}
}