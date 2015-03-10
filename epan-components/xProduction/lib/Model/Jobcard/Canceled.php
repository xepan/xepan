<?php

namespace xProduction;

class Model_Jobcard_Canceled extends Model_JobCard {
	
	function init(){
		parent::init();
		$this->addCondition('status','canceled');
	}
}	