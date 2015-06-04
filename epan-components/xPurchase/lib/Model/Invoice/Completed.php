<?php
namespace xPurchase;
class Model_Invoice_Completed extends Model_PurchaseInvoice{
	public $actions=array(
			'can_view'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','completed');
	}
}	