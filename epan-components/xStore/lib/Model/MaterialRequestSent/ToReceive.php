<?php

namespace xStore;

class Model_MaterialRequestSent_ToReceive extends Model_MaterialRequestSent {
	
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	