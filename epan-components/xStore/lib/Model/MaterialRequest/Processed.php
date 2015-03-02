<?php

namespace xStore;

class Model_MaterialRequest_Processed extends Model_MaterialRequest{
	
	function init(){
		parent::init();
		$this->addCondition('status','processed');
	}
}	