<?php
namespace xProduction;
class Model_Task_Processing extends Model_Task{
	function init(){
		parent::init();

		$this->addCondition('status','processing');
	}
}