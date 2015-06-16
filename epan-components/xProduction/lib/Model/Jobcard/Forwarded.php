<?php

namespace xProduction;

class Model_Jobcard_Forwarded extends Model_JobCard{
	public $actions=array(
			'can_view'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();

		$this->addExpression('forwarded_to')->set("'TODO'");

		$this->addCondition('status','forwarded');
	}
}	