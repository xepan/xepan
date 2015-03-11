<?php

namespace xProduction;

class Model_Jobcard_Forwarded extends Model_JobCard{
	
	function init(){
		parent::init();

		$this->addExpression('forwarded_to')->set("'TODO'");

		$this->addCondition('status','forwarded');
	}
}	