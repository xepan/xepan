<?php

namespace xStore;

class Model_MaterialRequestSent_Processing extends Model_MaterialRequestSent{
	
	function init(){
		parent::init();
		$this->addCondition('status','processing');
	}
}	