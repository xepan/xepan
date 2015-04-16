<?php
namespace xShop;

class Model_Invoice_Redesign extends Model_SalesInvoice{
	
	public $actions=array(
			'can_approve'=>array(),
			'can_cancel'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
			'can_submit'=>array(),
			'can_manage_attachments'=>array(),
			
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','redesign');
	}
}