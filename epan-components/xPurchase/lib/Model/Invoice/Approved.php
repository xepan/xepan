<?php
namespace xPurchase;
class Model_Invoice_Approved extends Model_PurchaseInvoice{
	public $actions=array(
			'can_view'=>array(),
			'can_cancel'=>array(),
			'can_mark_processed'=>array(),
			'can_send_via_email'=>array(),
			'can_see_activities'=>array(),
			'allow_edit'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	