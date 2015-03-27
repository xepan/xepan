<?php
namespace xPurchase;

class Model_PurchaseInvoice extends \xShop\Model_Invoice{

	public $root_document_name = 'xShop\PurchaseInvoice';
	function init(){
		parent::init();

		$this->addCondition('type','purchaseInvoice');
	}

	function supplier(){
		return $this->ref('customer_id');
	}
}