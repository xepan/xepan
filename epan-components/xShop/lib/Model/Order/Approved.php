<?php
namespace xShop;

class Model_Order_Approved extends Model_Order{

	public $actions=array(
			'can_view'=>array(),
			'can_cancel'=>array(),
			'can_send_via_email'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'can_forcedelete'=>array('icon'=>'trash-1 atk-swatch-red'),
			'can_see_activities'=>array(),
		);
	

	function init(){
		parent::init();

		$this->addCondition('status','approved');
	}
}