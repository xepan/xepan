<?php

namespace xProduction;

class Model_Jobcard_Approved extends Model_JobCard{

	public $actions=array(
			'can_view'=>array(),
			'can_receive'=>array(),
			'can_cancel'=>array(),
			'can_see_activities'=>array(),
		);
	
	
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	