<?php
namespace xPurchase;
class Model_PurchaseOrder_Approved extends Model_PurchaseOrder{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(approve) this post can see'),
			'can_reject'=>array('caption'=>'Can this post receive Jobcard(reject)'),
			'can_redesign'=>array('caption'=>'Can this post receive Jobcard(redesign)'),
			'can_start_processing'=>array('caption'=>'Can this post Mark Processing'),
		);
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	