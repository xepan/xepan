<?php

namespace xProduction;

class Model_Phase extends \xHR\Model_Department {
	
	function init(){
		parent::init();

		$this->addCondition('is_production_department',true);
	}
}