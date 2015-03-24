<?php

namespace xProduction;

class Model_Jobcard_Draft extends Model_JobCard {
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_submit'=>array(),
		);
	
	
	function init(){
		parent::init();
		$this->addCondition('status','draft');
	}
}	