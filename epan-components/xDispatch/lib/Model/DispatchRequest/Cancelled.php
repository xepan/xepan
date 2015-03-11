<?php

namespace xDispatch;

class Model_DispatchRequest_Cancelled extends Model_DispatchRequest{
	
	function init(){
		parent::init();

		$this->addCondition('status','cancel');

	}
}