<?php
namespace xPurchase;
class Model_Invoice_Submitted extends Model_PurchaseInvoice{
	public $actions=array(
			'can_view'=>array(),
			'can_approve'=>array(),
			'can_cancel'=>array(),
		);
	
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	