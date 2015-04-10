<?php
namespace xShop;

class Model_Order_Processed extends Model_Order{
	public $actions=array(
			'can_view'=>array(),
			'can_send_via_email'=>array(),
			'can_forcedelete'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_add'=>array(),
		);
	
	function init(){
		parent::init();

		$this->addCondition('status','processed');
	}
}