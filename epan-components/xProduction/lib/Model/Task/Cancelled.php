<?php
namespace xProduction;

class Model_Task_Cancelled extends Model_Task{
	public $actions=array(
			'can_view'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','cancelled');
	}
}