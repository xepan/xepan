<?php
namespace xShop;

class Model_Invoice_Submitted extends Model_SalesInvoice{
	
	public $actions=array(
			'can_approve'=>array(),
			'can_cancel'=>array(),
			
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','submitted');
	}
}