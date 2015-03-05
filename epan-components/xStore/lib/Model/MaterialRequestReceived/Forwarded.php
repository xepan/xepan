<?php

namespace xStore;

class Model_MaterialRequestReceived_Forwarded extends Model_MaterialRequestReceived{
	
	function init(){
		parent::init();
		$this->addCondition('status','forwarded');
	}
}	