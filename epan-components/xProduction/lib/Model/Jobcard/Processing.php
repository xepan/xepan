<?php

namespace xProduction;

class Model_Jobcard_Processing extends Model_JobCard{
	
	function init(){
		parent::init();
		$this->addCondition('status','processing');
	}
}	