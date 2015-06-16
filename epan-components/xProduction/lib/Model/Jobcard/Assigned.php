<?php

namespace xProduction;

class Model_Jobcard_Assigned extends Model_JobCard{
	
		public $actions=array(
			'can_view'=>array(),
			'can_start_processing'=>array(),
			'can_see_activities'=>array(),
		);
	
	function init(){
		parent::init();
		// addExpression .. assigned_to .. from log

		$this->addCondition('status','assigned');
	}

	function reAssign($employee){
		$this->assignTo($employee);
	}
}	