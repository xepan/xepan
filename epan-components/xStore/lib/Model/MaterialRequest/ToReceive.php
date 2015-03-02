<?php

namespace xStore;

class Model_MaterialRequest_ToReceive extends Model_MaterialRequest {
	
	function init(){
		parent::init();
		$this->addCondition('status','-');
	}
}	