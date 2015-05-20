<?php
namespace xShop;

class Model_Invoice_Approved extends Model_SalesInvoice{
	
	public $actions=array(
			'can_view'=>array(),
			'allow_del'=>array(),
			'allow_edit'=>array(),
			'can_cancel'=>array(),
			'can_mark_processed'=>array(),
			'can_send_via_email'=>array()
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','approved');
	}
}