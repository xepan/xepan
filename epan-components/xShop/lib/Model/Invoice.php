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
		
		$this->hasOne('xShop/OrderDetails','orderitem_id')->sortable(true);
		$this->hasOne('xShop/Customer','customer_id')->sortable(true);
		$this->hasOne('xPurchase/Supplier','supplier_id')->sortable(true);
		$this->hasOne('xShop/Model_Order','sales_order_id');
		$this->hasOne('xPurchase/Model_PurchaseOrder','po_id')->caption('Purchase Order');
		$this->hasOne('xShop/TermsAndCondition','termsandcondition_id')->display(array('form'=>'autocomplete/Basic'))->caption('Terms & Cond.');

		$this->addField('type')->enum(array('salesInvoice','purchaseInvoice'));
		$this->addField('name')->caption('Invoice No');
		$this->addField('total_amount')->type('money');
		$this->addField('gross_amount')->type('money')->sortable(true);
		$this->addField('discount')->type('money');
		$this->addField('tax')->type('money');
		$this->addField('net_amount')->type('money');
		$this->addField('billing_address')->type('text');
		$this->addField('transaction_reference')->type('text');
		$this->addField('transaction_response_data')->type('text');
		$this->hasMany('xShop/InvoiceItem','invoice_id');
		$this->addHook('beforeDelete',$this);
		$this->addHook('beforeSave',$this);
		$this->addHook('afterSave',$this);

		$this->add('dynamic_model/Controller_AutoCreator');
	}
	
	function afterSave(){
		$this->updateAmounts();
	}

	function updateAmounts(){
		
		$this['total_amount']=0;
		$this['gross_amount']=0;
		$this['tax']=0;
		$this['net_amount']=0;
		
		foreach ($this->itemrows() as $oi) {
			$this['total_amount'] = $this['total_amount'] + $oi['amount'];
			$this['gross_amount'] = $this['gross_amount'] + $oi['texted_amount'];
			$this['tax'] = $this['tax'] + $oi['tax_amount'];
			$this['net_amount'] = $this['total_amount'] + $this['tax'] - $this['discount_voucher_amount'];
		}	
		$this->save();
	}

	function beforeSave(){
		if($this['customer'] and $this['supplier'])
			throw $this->Exception('Select Either Customer or Supplier','ValidityCheck')->setField('customer_id');
		
		if($this['sales_order'] and $this['po'])
			throw $this->Exception('Select Either Sales Order or Purchase Order','ValidityCheck')->setField('sales_order_id');
	}


	function beforeDelete(){
		$this->ref('xShop/InvoiceItem')->deleteAll();
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
	function orderItem(){
		if(!$this['orderitem_id']){
			return false;
		}
		return $this->ref('orderitem_id');
	}

	function isApproved(){
		if(!$this->loaded())
			return false;
		
		$this->addCondition('status','<>','submitted');
		$this->addCondition('status','<>','draft');
		$this->tryLoadAny();
		return $this;
	}

	function addItem($item,$qty,$rate,$amount,$unit,$narration,$custom_fields){
		$in_item = $this->ref('xShop/InvoiceItem');
		$in_item['item_id'] = $item->id;
		$in_item['qty'] = $qty;
		$in_item['rate'] = $rate;
		$in_item['amount'] = $amount;
		$in_item['unit'] = $unit;
		$in_item['narration'] = $narration;
		$in_item['custom_fields'] = $custom_fields;
		$in_item->save();
	}


	function send_via_email_page($p){

		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');
		
		$view=$this->add('xShop/View_InvoiceDetail');
		$view->setModel($this->itemrows());

		$customer = $this->customer();
		$customer_email=$customer->get('customer_email');

		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
		
		$subject = $config_model['invoice_email_subject']?:"INVOICE";
		
		$email_body=$config_model['invoice_email_body']?:"Invoice Layout Is Empty";
		
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$email_body = str_replace("{{customer_name}}", $customer['customer_name'], $email_body);
		$email_body = str_replace("{{mobile_number}}", $customer['mobile_number'], $email_body);
		$email_body = str_replace("{{order_billing_address}}",$customer['billing_address']?"Address.:".$customer['billing_address']:" ", $email_body);
		$email_body = str_replace("{{order_shipping_address}}",$customer['shipping_address']?"Shipping Address.:".$customer['shipping_address']:" ", $email_body);
		$email_body = str_replace("{{customer_email}}", $customer['customer_email'], $email_body);
		$email_body = str_replace("{{customer_tin_no}}", $customer['tin_no']?"TIN No.:".$customer['tin_no']:" ", $email_body);
		$email_body = str_replace("{{invoice_details}}", $view->getHtml(), $email_body);
		$email_body = str_replace("{{customer_pan_no}}", $customer['pan_no']?"PAN No.:".$customer['pan_no']:" ", $email_body);
		$email_body = str_replace("{{invoice_order_no}}", $this['name'], $email_body);
		$email_body = str_replace("{{invoice_date}}", $this['created_at'], $email_body);
		$email_body = str_replace("{{dispatch_challan_no}}", "", $email_body);
		$email_body = str_replace("{{dispatch_challan_date}}", "", $email_body);
		// $email_body = str_replace("{{dispatch_challan_date}}", $this['created_at'], $email_body);
		// $email_body = str_replace("{{terms_and_condition}}", "", $email_body);
		//END OF REPLACING VALUE INTO ORDER DETAIL EMAIL BODY
		// return;
		$emails = explode(',', $customer['customer_email']);
		
		$form = $p->add('Form');
		$form->addField('line','to')->set($emails[0]);
		// array_pop(array_re/verse($emails));
		unset($emails[0]);

		$form->addField('line','cc')->set(implode(',',$emails));
		$form->addField('line','bcc');
		$form->addField('line','subject')->set($subject);
		$form->addField('RichText','message')->set($email_body);
		$form->addSubmit('Send');
		// echo 'hello';
		if($form->isSubmitted()){
			$this->sendEmail($form['to'],$form['subject'],$form['message'],explode(',',$form['cc']),explode(',',$form['bcc']));	
			$form->js(null,$form->js()->reload())->univ()->successMessage('Send Successfully')->execute();
		}
		
	}
}