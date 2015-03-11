<?php

namespace xDispatch;

class Model_DispatchRequest_Received extends Model_DispatchRequest{
	
	function init(){
		parent::init();

		$this->addCondition('status','received');

	}
}