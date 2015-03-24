<?php

namespace xDispatch;

class Model_DispatchRequest_Completed extends Model_DispatchRequest{
	public $actions=array(
			'can_view'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','completed');

	}
}