<?php
namespace xPurchase;
class Model_PurchaseOrder_Approved extends Model_PurchaseOrder{
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	