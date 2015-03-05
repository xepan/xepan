<?php

namespace xStore;

class Model_MaterialRequestSent_Forwarded extends Model_MaterialRequestSent{
	
	function init(){
		parent::init();
		$this->addCondition('status','forwarded');
	}
}	