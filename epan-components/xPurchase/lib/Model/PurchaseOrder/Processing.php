<?php
namespace xPurchase;
class Model_PurchaseOrder_Processing extends Model_PurchaseOrder{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard this post can see'),
			'can_mark_processed'=>array('caption'=>'Whose Created  this post can Processed')
		);
	function init(){
		parent::init();
		$this->addCondition('status','processing');
	}
}	