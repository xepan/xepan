<?php

namespace xProduction;

class Model_Jobcard_Draft extends Model_JobCard {
	
	function init(){
		parent::init();
		$this->addCondition('status','draft');
	}
}	