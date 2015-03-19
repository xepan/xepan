<?php

namespace xShop;

class Model_Quotation extends \Model_Document{
	public $table="xshop_quotation";
	public $status=array('draft','approved','redesign','submitted','cancelled');
	public $root_document_name="xShop\Quotation";

	function init(){
		parent::init();
		$this->hasOne('xMarketingCampaign/Lead','lead_id')->sortable(true);
		$this->hasOne('xShop/Opportunity','opportunity_id')->sortable(true);
		$this->hasOne('xShop/Customer','customer_id')->sortable(true);
		$this->hasOne('xShop/TermsAndCondition','termsandcondition_id')->sortable(true);

		$this->addField('name')->Caption('Quotation Number')->sortable(true);
		// $this->addField('quotation_no');
		$this->getElement('status')->enum($this->status)->defaultValue('draft');
		$this->addHook('beforeDelete',$this);

		$this->hasMany('xShop/QuotationItem','quotation_id');

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		$this->ref('xShop/QuotationItem')->deleteAll();
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

}

