<?php
namespace xPurchase;
class Model_PurchaseOrder_Completed extends Model_PurchaseOrder{
	function init(){
		parent::init();
		$this->addCondition('status','completed');
	}
}	