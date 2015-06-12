<?php
namespace xShop;

class Model_Order_Completed extends Model_Order{
	public $actions=array(
			'can_view'=>array(),
			'can_forcedelete'=>array(),
			'can_see_activities'=>array(),
			'can_send_via_email'=>array('caption'=>'Email'),
		);
	
	function init(){
		parent::init();

		$this->addCondition('status','completed');
	}
}