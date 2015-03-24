<?php
namespace xPurchase;
class Model_PurchaseOrder_Approved extends Model_PurchaseOrder{
	public $actions=array(
			'can_view'=>array(),
			'can_reject'=>array(),
			'can_redesign'=>array(),
			'can_start_processing'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	