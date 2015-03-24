<?php
namespace xPurchase;
class Model_PurchaseOrder_Processing extends Model_PurchaseOrder{
	public $actions=array(
			'can_view'=>array(),
			'can_mark_processed'=>array('icon'=>'ok')
		);
	function init(){
		parent::init();
		$this->addCondition('status','processing');
	}
}	