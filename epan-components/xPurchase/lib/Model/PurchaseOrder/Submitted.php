<?php
namespace xPurchase;
class Model_PurchaseOrder_Submitted extends Model_PurchaseOrder{
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	