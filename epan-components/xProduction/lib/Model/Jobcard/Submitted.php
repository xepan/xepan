<?php

namespace xProduction;

class Model_Jobcard_Submitted extends Model_JobCard {
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'can_approve'=>array('icon'=>' atk-swatch-red'),
			'can_reject'=>array('icon'=>'cancel-circled atk-swatch-red'),
		);
	
	
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	