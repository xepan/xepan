<?php

namespace xStore;

class Model_MaterialRequestReceived_Completed extends Model_MaterialRequestReceived{
	public $actions=array(
			'can_view'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','completed');
	}
}	