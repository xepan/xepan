<?php
namespace xShop;

class Model_Invoice_Submitted extends Model_SalesInvoice{
	
	public $actions=array(
			'can_approve'=>array(),
			'can_cancel'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
			'can_reject'=>array(),
			'can_see_activities'=>array(),
		);

	function init(){
		parent::init();
		
		$this->addCondition('status','submitted');
	}
}