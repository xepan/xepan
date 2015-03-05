<?php

namespace xStore;

class Model_MaterialRequestReceived_Received extends Model_MaterialRequestReceived{
	
	function init(){
		parent::init();
		$this->addCondition('status','received');
	}
}	