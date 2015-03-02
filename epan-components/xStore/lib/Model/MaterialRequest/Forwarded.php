<?php

namespace xStore;

class Model_MaterialRequest_Forwarded extends Model_MaterialRequest{
	
	function init(){
		parent::init();
		$this->addCondition('status','forwarded');
	}
}	