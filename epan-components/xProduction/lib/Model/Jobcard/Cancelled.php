<?php

namespace xProduction;

class Model_Jobcard_Cancelled extends Model_JobCard {
	public $actions=array(
			'can_view'=>array(),
			'allow_del'=>array(),
			'can_see_activities'=>array(),
		);
	
	function init(){
		parent::init();
		$this->addCondition('status','cancelled');
	}
}	