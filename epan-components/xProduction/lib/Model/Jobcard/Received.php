<?php

namespace xProduction;

class Model_Jobcard_Received extends Model_JobCard{
	
	function init(){
		parent::init();
		$this->addCondition('status','received');
	}
}	