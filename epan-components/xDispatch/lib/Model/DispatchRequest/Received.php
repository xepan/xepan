<?php

namespace xDispatch;

class Model_DispatchRequest_Received extends Model_DispatchRequest{
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'can_assign'=>array(),
			'can_assign_to'=>array(),
			'can_mark_processed'=>array(),
			'can_cancel'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','received');

	}
}