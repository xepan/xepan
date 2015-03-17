<?php

namespace xStore;

class Model_MaterialRequestSent_Processed extends Model_MaterialRequestSent{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard this post can see'),
			'can_accept'=>array('caption'=>'Whose created Jobcard this post can accept'),
				
		);
	function init(){
		parent::init();
		$this->addCondition('status','processed');
	}
}	