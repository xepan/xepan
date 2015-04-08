<?php
namespace xShop;

class Model_Invoice_Completed extends Model_SalesInvoice{
	
	public $actions=array(
			'can_view'=>array(),
			'can_send_via_email'=>array()
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','completed');
	}
}