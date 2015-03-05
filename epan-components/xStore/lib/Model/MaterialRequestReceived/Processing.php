<?php

namespace xStore;

class Model_MaterialRequestReceived_Processing extends Model_MaterialRequestReceived{
	
	function init(){
		parent::init();
		$this->addCondition('status','processing');
	}
}	