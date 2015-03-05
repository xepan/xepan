<?php

namespace xStore;

class Model_MaterialRequestReceived_ToReceive extends Model_MaterialRequestReceived {
	
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	