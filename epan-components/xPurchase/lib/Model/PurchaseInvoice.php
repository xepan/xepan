<?php
namespace xPurcahse;
class Model_PurchaseInvoice extends xShop\Model_Invoice{

	function init(){
		parent::init();
		$this->addCondition('type','purchaseInvoice');
	}
}