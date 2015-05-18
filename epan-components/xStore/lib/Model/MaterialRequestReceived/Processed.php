<?php

namespace xStore;

class Model_MaterialRequestReceived_Processed extends Model_MaterialRequestReceived{
	public $actions=array(
			'can_view'=>array(),
			'can_accept'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','processed');
	}
}	