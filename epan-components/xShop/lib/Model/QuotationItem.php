<?php

namespace xShop;
class Model_QuotationItem extends \Model_Document{
	
	public $table="xshop_quotation_item";
	public $status=array();
	public $root_document_name="QuotationItem";

	function init(){
		parent::init();
		$this->hasOne('xShop/Quotation','quotation_id');
		$this->hasOne('xShop/Item','item_id');
		
		$this->addField('qty');
		$this->addField('rate');
		$this->addField('amount');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}