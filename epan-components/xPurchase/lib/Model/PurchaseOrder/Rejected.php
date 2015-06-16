<?php
namespace xPurchase;
class Model_PurchaseOrder_Rejected extends Model_PurchaseOrder{
	public $actions=array(
			'can_view'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','rejected');
	}
}	