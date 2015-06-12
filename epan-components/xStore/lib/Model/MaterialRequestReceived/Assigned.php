<?php

namespace xStore;

class Model_MaterialRequestReceived_Assigned extends Model_MaterialRequestReceived{
	public $actions=array(
			'can_view'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();

		// addExpression .. assigned_to .. from log

		$this->addCondition('status','assigned');
	}

}	