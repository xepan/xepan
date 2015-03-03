<?php

namespace xProduction;

class Model_MaterialRequirment_Submit extends Model_MaterialRequirment{
	
	function init(){
		parent::init();

		$this->addCondition('status','submit');
	}

}