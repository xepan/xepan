<?php
namespace xShop;

class Model_Invoice_Completed extends Model_SalesInvoice{
	
	public $actions=array(
			'can_view'=>array(),
			'can_cancel'=>array(),
			'can_send_via_email'=>array('caption'=>'E-mail','default'=>'Self Only'),
			'can_see_activities'=>array(),
			'allow_del'=>array(),
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','completed');
	}
}