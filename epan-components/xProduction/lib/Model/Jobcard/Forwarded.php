<?php

namespace xProduction;

class Model_Jobcard_Forwarded extends Model_JobCard{
	
	function init(){
		parent::init();
		$this->addCondition('status','forwarded');
	}
}	