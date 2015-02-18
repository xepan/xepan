<?php

namespace xProduction;

class Model_Jobcard_Completed extends Model_JobCard{
	
	function init(){
		parent::init();
		$this->addCondition('status','completed');
	}
}	