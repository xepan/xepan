<?php

namespace xStore;

class Model_MaterialRequestSent_Completed extends Model_MaterialRequestSent{
	
	function init(){
		parent::init();
		$this->addCondition('status','completed');
	}
}	