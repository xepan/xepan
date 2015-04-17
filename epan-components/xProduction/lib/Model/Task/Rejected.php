<?php
namespace xProduction;

class Model_Task_Rejected extends Model_Task{
	public $actions=array(
			'can_view'=>array(),
			'allow_add'=>array(),
			'allow_edit'=>array(),
			'allow_del'=>array(),
			'can_assign'=>array()
		);
	function init(){
		parent::init();

		$this->addCondition('status','rejected');
	}
}