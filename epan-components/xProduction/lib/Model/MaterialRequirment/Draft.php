<?php

namespace xProduction;

class Model_MaterialRequirment_Draft extends Model_MaterialRequirment{
	
	function init(){
		parent::init();

		$this->addCondition('status','draft');
	}

}