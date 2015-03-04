<?php
namespace xPurchase;
class Model_PurchaseOrder_Draft extends Model_PurchaseOrder{
	function init(){
		parent::init();
		$this->addCondition('status','draft');
	}
}	