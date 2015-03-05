<?php

namespace xStore;

class Model_MaterialRequestReceived_Completed extends Model_MaterialRequestReceived{
	
	function init(){
		parent::init();
		$this->addCondition('status','completed');
	}
}	