<?php
namespace xShop;

class Model_Order_Submitted extends Model_Order{

	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'can_approve'=>array(),
			'can_reject'=>array(),
			'can_cancel'=>array(),
		);
	
	function init(){
		parent::init();

		$this->addCondition('status','submitted');
	}
}