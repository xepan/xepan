<?php

namespace xStore;

class Model_MaterialRequestReceived_Processed extends Model_MaterialRequestReceived{
	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Jobcard this post can see'),
		);
	function init(){
		parent::init();
		$this->addCondition('status','processed');
	}
}	