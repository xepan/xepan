<?php

namespace xStore;

class Model_MaterialRequestSent_Received extends Model_MaterialRequestSent{
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'can_assign'=>array(),
			'can_assign_to'=>array(),
		);
	function init(){
		parent::init();
		$this->addCondition('status','received');
	}
}	