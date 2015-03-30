<?php
namespace xPurchase;
class Model_PurchaseOrder_Submitted extends Model_PurchaseOrder{
	public $actions=array(
			'can_view'=>array(),
			'can_redesign'=>array(),
			'allow_edit'=>array(),
			'can_approve'=>array(),
			'can_reject'=>array('icon'=>'cancel-circled'),
			'can_cancle'=>array('icon'=>'cancel')
		);
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	