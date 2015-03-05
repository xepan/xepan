<?php

namespace xStore;

class Model_MaterialRequestSent_Assigned extends Model_MaterialRequestSent{
	
	function init(){
		parent::init();

		// addExpression .. assigned_to .. from log

		$this->addCondition('status','assigned');
	}

}	