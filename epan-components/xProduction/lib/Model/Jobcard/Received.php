<?php

namespace xProduction;

class Model_Jobcard_Received extends Model_JobCard{

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard(received) this post can see'),
			'can_assign'=>array('caption'=>'Whose created Jobcard(received) this post can assign'),
			'can_assign_to'=>array('caption'=>' Whose created Jobcard(received) this post can assign to'),
			'can_mark_processed'=>array('caption'=>'Whose Created  this post can delete'),
		);
	
	function init(){
		parent::init();
		$this->addCondition('status','received');
	}
}	