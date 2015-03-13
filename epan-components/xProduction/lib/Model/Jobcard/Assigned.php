<?php

namespace xProduction;

class Model_Jobcard_Assigned extends Model_JobCard{
	
		public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard this post can see'),
			'can_start_processing'=>array('caption'=>'Whose Created  this post can Processing')
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