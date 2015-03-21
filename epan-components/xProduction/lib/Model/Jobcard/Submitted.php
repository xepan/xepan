<?php

namespace xProduction;

class Model_Jobcard_Submitted extends Model_JobCard {
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(submit) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Jobcard(submit) this post can edit'),
			'can_approve'=>array('caption'=>'Can this post approve Jobcard(submit)'),
			'can_reject'=>array('icon'=>'cancle-circle atk-swatch-red'),
		);
	
	
	function init(){
		parent::init();
		$this->addCondition('status','submitted');
	}
}	