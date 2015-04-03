<?php

namespace xProduction;

class Model_Jobcard_Processed extends Model_JobCard{
	public $actions=array(
			'can_view'=>array(),
			'can_forward'=>array('icon'=>'forward'),
			'can_cancel'=>array(),
		);
	function init(){
		parent::init();
		
		$this->addCondition('status','processed');
	}
}	