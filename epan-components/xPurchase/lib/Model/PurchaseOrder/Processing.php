<?php
namespace xPurchase;
class Model_PurchaseOrder_Processing extends Model_PurchaseOrder{
	function init(){
		parent::init();
		$this->addCondition('status','processing');
	}
}	