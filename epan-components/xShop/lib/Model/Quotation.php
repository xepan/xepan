<?php

namespace xShop;

class Model_Quotation extends \Model_Document{
	public $table="xshop_quotation";
	public $status=array('draft','approved','redesign','submitted','cancelled');
	public $root_document_name="xShop\Quotation";

	function init(){
		parent::init();

		$this->hasOne('xMarketingCampaign/Lead','lead_id')->sortable(true)->display(array('form'=>'autocomplete/Plus'));
		$this->hasOne('xShop/Opportunity','opportunity_id')->sortable(true)->display(array('form'=>'autocomplete/Basic'));
		$this->hasOne('xShop/Customer','customer_id')->sortable(true)->display(array('form'=>'autocomplete/Basic'));
		$this->hasOne('xShop/TermsAndCondition','termsandcondition_id')->sortable(true)->display(array('form'=>'autocomplete/Basic'));

		$this->addField('name')->Caption('Quotation Number')->sortable(true)->hint('For Autogenerated, Leave Empty');
		// $this->addField('quotation_no');
		$this->getElement('status')->enum($this->status)->defaultValue('draft');

		$this->addField('total_amount')->type('money')->mandatory(true)->sortable(true);
		$this->addField('gross_amount')->type('money')->mandatory(true)->sortable(true);
		$this->addField('discount_voucher')->group('b~3');
		$this->addField('discount_voucher_amount')->group('b~3')->defaultValue(0);
		$this->addField('tax')->type('money')->group('b~3');
		$this->addField('net_amount')->type('money')->mandatory(true)->group('b~3')->sortable(true);

		$this->addHook('beforeDelete',$this);
		$this->addHook('beforeSave',$this);
		$this->addHook('afterSave',$this);

		$this->hasMany('xShop/QuotationItem','quotation_id');
		$this->hasMany('xShop/SalesOrderAttachment','related_document_id',null,'Attachements');

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function afterSave(){
		$this->updateAmounts();
	}

	function beforeDelete(){
		$this->ref('xShop/QuotationItem')->deleteAll();
	}

	function beforeSave(){
		if($this['lead_id'] and $this['customer_id'])
			throw $this->exception('Select Either Lead or Customer','ValidityCheck')->setField('customer_id');
			
	}

	function updateAmounts(){
		$this['total_amount']=0;
		$this['gross_amount']=0;
		$this['tax']=0;
		$this['net_amount']=0;
		
		foreach ($this->itemRows() as $oi) {
			$this['total_amount'] = $this['total_amount'] + $oi['amount'];
			$this['gross_amount'] = $this['gross_amount'] + $oi['texted_amount'];
			$this['tax'] = $this['tax'] + $oi['tax_amount'];
			$this['net_amount'] = $this['total_amount'] + $this['tax'] - $this['discount_voucher_amount'];
		}
		$this->save();
	}
	function submit(){
		parent::setStatus('submitted');
	}


	function reject($message){
		$this->setStatus('rejected');
	}
	

	function sendMail(){
		return "sendMail";
	}

	function status(){
		return $this['status'];
	}

	function itemrows(){
		return $this->add('xShop/Model_QuotationItem')->addCondition('quotation_id',$this->id);
	}

	function customer(){
		return $this->ref('customer_id');
	}

	function send_via_email_page($email_id=null, $order_id=null){

		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');
		
		$subject ="Thanku for Order";
		$customer = $this->customer();
		$customer_email=$customer->get('customer_email');

		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
		
		$subject = $config_model['quotation_email_subject']?:$this['name']." "."::"." "."Quotation";
		
		$email_body=$config_model['quotation_email_body']?:"Quotation Layout Is Empty";
		
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$email_body = str_replace("{{customer_name}}", $customer['customer_name'], $email_body);
		$email_body = str_replace("{{mobile_number}}", $customer['mobile_number'], $email_body);
		$email_body = str_replace("{{address}}",$customer['address'], $email_body);
		$email_body = str_replace("{{order_billing_address}}",$customer['billing_address'], $email_body);
		$email_body = str_replace("{{order_shipping_address}}",$customer['shipping_address'], $email_body);
		$email_body = str_replace("{{customer_email}}", $customer['customer_email'], $email_body);
		$email_body = str_replace("{{quotation_no}}", $this['name'], $email_body);
		$email_body = str_replace("{{quotation_date}}", $this['created_at'], $email_body);
		//END OF REPLACING VALUE INTO ORDER DETAIL EMAIL BODY
		// echo $email_body;
		// return;
		$this->sendEmail($customer_email,$subject,$email_body);
		
	}

}

