<?php
namespace xPurchase;
class Model_PurchaseOrder_Redesign extends Model_PurchaseOrder{
	function init(){
		parent::init();
		$this->addCondition('status','redesign');
	}
}	