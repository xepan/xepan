<?php
namespace xPurchase;
class Model_PurchaseOrder_Approved extends Model_PurchaseOrder{
	public $actions=array(
			'can_view'=>array(),
			'can_reject'=>array(),
			'can_redesign'=>array(),
			'can_send_via_email'=>array(),
			'can_mark_processed'=>array(),
			'can_forceDelete'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	