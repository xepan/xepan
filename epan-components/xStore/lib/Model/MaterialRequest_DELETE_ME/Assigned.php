<?php

namespace xStore;

class Model_MaterialRequest_Assigned extends Model_MaterialRequest{
	
	function init(){
		parent::init();

		// addExpression .. assigned_to .. from log

		$this->addCondition('status','assigned');
	}

}	