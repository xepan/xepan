<?php
namespace xProduction;

class Model_Task_Assigned extends Model_Task{
	public $actions=array(
			'can_view'=>array(),
			'can_reject'=>array(),
			'can_start_processing'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','assigned');
	}
}