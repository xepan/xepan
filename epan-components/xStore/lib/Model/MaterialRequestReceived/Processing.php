<?php

namespace xStore;

class Model_MaterialRequestReceived_Processing extends Model_MaterialRequestReceived{
	public $actions=array(
			'can_view'=>array(),
			'can_mark_processed'=>array('icon'=>'ok'),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','processing');
	}
}	