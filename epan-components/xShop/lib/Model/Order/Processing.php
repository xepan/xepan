<?php
namespace xShop;

class Model_Order_Processing extends Model_Order{
	public $actions=array(
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'can_view'=>array(),
			'can_send_via_email'=>array(),
			'can_cancel'=>array(),
			'can_forcedelete'=>array(),
			'can_see_activities'=>array(),
		);
	
	function init(){
		parent::init();

		$this->addCondition('status','processing');
	}
}