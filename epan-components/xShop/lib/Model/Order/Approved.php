<?php
namespace xShop;

class Model_Order_Approved extends Model_Order{

	public $actions=array(
			'can_view'=>array(),
			'can_reject'=>array(),
			'can_forcedelete'=>array()
		);
	

	function init(){
		parent::init();

		$this->addCondition('status','approved');
	}
}