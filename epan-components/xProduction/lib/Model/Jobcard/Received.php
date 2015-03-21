<?php

namespace xProduction;

class Model_Jobcard_Received extends Model_JobCard{

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(received) this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Jobcard this post can edit'),
			'can_assign'=>array('caption'=>'Whose created Jobcard(received) this post can assign'),
			'can_assign_to'=>array('caption'=>' Whose created Jobcard(received) this post can assign to'),
			'can_start_processing'=>array('caption'=>' Whose created Jobcard(received) this post can start processing'),
			'can_mark_processed'=>array('icon'=>'ok'),
		);
	
	function init(){
		parent::init();
		$this->addCondition('status','received');
	}
}	