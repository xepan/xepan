<?php
namespace xProduction;

class Model_Task_Draft extends Model_Task{
	public $actions=array(
			'can_view'=>array(),
			'can_start_processing'=>array(),
			'can_mark_processed'=>array(),
			'can_assign'=>array()
		);
	function init(){
		parent::init();

		$this->addCondition('status','draft');
	}
}