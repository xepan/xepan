<?php
namespace xPurchase;
class Model_PurchaseOrder_Rejected extends Model_PurchaseOrder{
	function init(){
		parent::init();
		$this->addCondition('status','rejected');
	}
}	