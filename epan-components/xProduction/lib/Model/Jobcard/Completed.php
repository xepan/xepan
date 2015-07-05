<?php

namespace xProduction;

class Model_Jobcard_Completed extends Model_JobCard{
	public $actions=array(
			'can_view'=>array(),
			'can_send_via_email'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','completed');
	}
}	