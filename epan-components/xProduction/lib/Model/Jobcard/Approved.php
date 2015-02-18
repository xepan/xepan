<?php

namespace xProduction;

class Model_Jobcard_Approved extends Model_JobCard{
	
	function init(){
		parent::init();
		$this->addCondition('status','approved');
	}
}	