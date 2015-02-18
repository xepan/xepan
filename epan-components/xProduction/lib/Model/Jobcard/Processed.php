<?php

namespace xProduction;

class Model_Jobcard_Processed extends Model_JobCard{
	
	function init(){
		parent::init();
		$this->addCondition('status','processed');
	}
}	