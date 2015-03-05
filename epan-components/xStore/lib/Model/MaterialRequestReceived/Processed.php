<?php

namespace xStore;

class Model_MaterialRequestReceived_Processed extends Model_MaterialRequestReceived{
	
	function init(){
		parent::init();
		$this->addCondition('status','processed');
	}
}	