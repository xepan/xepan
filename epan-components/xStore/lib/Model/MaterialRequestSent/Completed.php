<?php

namespace xStore;

class Model_MaterialRequestSent_Completed extends Model_MaterialRequestSent{
	public $actions=array(
			'can_view'=>array(),
			'can_see_activities'=>array(),
				
		);
	function init(){
		parent::init();
		$this->addCondition('status','completed');
	}
}	