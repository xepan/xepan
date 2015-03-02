<?php

namespace xStore;

class Model_MaterialRequest_Processing extends Model_MaterialRequest{
	
	function init(){
		parent::init();
		$this->addCondition('status','processing');
	}
}	