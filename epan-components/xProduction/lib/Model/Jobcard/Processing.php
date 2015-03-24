<?php

namespace xProduction;

class Model_Jobcard_Processing extends Model_JobCard{
	public $actions=array(
			'can_view'=>array(),
			'can_mark_processed'=>array('icon'=>'ok')
		);
	
	function init(){
		parent::init();
		$this->addCondition('status','processing');
	}
}	