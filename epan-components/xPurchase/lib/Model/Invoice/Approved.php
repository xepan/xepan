<?php
namespace xPurchase;
class Model_Invoice_Approved extends Model_PurchaseInvoice{
	public $actions=array(
			'can_view'=>array(),
			'can_cancel'=>array(),
			
		);
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	