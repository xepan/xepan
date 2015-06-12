<?php
namespace xShop;

class Model_Invoice_Approved extends Model_SalesInvoice{
	
	public $actions=array(
			'can_view'=>array(),
			'can_mark_processed'=>array('caption'=>'Paid & Cleared','icon'=>'money atk-swatch-green','title'=>'Hello There', 'function'=>'mark_paid_and_complete','default'=>'Self Only'),
			'can_manage_attachments'=>array(),
			'can_send_via_email'=>array('caption'=>'E-mail','default'=>'Self Only'),
			'can_see_activities'=>array(),
			'can_cancel'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','approved');
	}
}