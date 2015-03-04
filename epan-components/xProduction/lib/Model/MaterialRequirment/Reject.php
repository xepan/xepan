<?php

namespace xProduction;

class Model_MaterialRequirment_Reject extends Model_MaterialRequirment{
	
	function init(){
		parent::init();

		$this->addCondition('status','reject');
	}

}