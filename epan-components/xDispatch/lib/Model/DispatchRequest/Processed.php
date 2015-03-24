<?php

namespace xDispatch;

class Model_DispatchRequest_Processed extends Model_DispatchRequest{
	public $actions=array(
			'can_view'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','processed');

	}
}