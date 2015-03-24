<?php

namespace xProduction;

class Model_Jobcard_Received extends Model_JobCard{

	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'can_assign'=>array(),
			'can_assign_to'=>array(),
			'can_start_processing'=>array('icon'=>'spinner'),
			'can_mark_processed'=>array('icon'=>'ok'),
		);
	
	function init(){
		parent::init();
		$this->addCondition('status','received');
	}
}	