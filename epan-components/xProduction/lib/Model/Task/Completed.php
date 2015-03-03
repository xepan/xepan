<?php
namespace xProduction;

class Model_Task_Completed extends Model_Task{
	function init(){
		parent::init();

		$this->addCondition('status','complete');
	}
}