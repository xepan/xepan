<?php
namespace xShop;

class Model_Order_Redesign extends Model_Order{

	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_submit'=>array(),
			'can_see_activities'=>array(),
		);
	

	function init(){
		parent::init();

		$this->addCondition('status','redesign');
	}
}