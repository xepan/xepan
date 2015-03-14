<?php
namespace xPurchase;
class Model_PurchaseOrder_Rejected extends Model_PurchaseOrder{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard this post can see'),
		);
	function init(){
		parent::init();
		$this->addCondition('status','rejected');
	}
}	