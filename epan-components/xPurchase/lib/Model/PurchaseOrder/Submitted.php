<?php
namespace xPurchase;
class Model_PurchaseOrder_Submitted extends Model_PurchaseOrder{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(approve) this post can see'),
			'can_redesign'=>array('caption'=>'Can this post receive Jobcard(redesign)'),
			'allow_edit'=>array('caption'=>'Whose created Jobcard(submit) this post can edit'),
			'can_approve'=>array('caption'=>'Can this post approve Jobcard(submit)'),
			'can_reject'=>array('icon'=>'cancel-circled')
		);
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	