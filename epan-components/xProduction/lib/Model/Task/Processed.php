<?php
namespace xProduction;
class Model_Task_Processed extends Model_Task{
	function init(){
		parent::init();

		$this->addCondition('status','processed');
	}
}