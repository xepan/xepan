<?php
namespace xProduction;

class Model_Task_Assigned extends Model_Task{
	function init(){
		parent::init();

		$this->addCondition('status','assigned');
	}
}