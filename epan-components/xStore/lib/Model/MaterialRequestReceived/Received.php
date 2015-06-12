<?php

namespace xStore;

class Model_MaterialRequestReceived_Received extends Model_MaterialRequestReceived{
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			// 'can_assign'=>array(),
			// 'can_assign_to'=>array(),
			'can_start_processing'=>array('icon'=>'spinner'),
			'can_mark_processed'=>array('icon'=>'ok'),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','received');
	}
}	