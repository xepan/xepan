<?php

namespace xProduction;

class Model_MaterialRequirment_Approved extends Model_MaterialRequirment{
	
	function init(){
		parent::init();

		$this->addCondition('status','approved');
	}

}