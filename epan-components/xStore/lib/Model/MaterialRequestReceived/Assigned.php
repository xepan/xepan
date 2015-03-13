<?php

namespace xStore;

class Model_MaterialRequestReceived_Assigned extends Model_MaterialRequestReceived{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard this post can see'),
		);
	function init(){
		parent::init();

		// addExpression .. assigned_to .. from log

		$this->addCondition('status','assigned');
	}

}	