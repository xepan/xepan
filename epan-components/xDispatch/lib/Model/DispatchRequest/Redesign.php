<?php

namespace xDispatch;

class Model_DispatchRequest_Redesign extends Model_DispatchRequest{
	public $actions=array(
			'can_view'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','redesign');

	}
}