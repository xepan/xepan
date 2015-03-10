<?php

namespace xProduction;

class Model_Jobcard_Submitted extends Model_JobCard {
	
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	