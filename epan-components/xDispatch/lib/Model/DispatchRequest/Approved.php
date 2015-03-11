<?php

namespace xDispatch;

class Model_DispatchRequest_Approved extends Model_DispatchRequest{
	
	function init(){
		parent::init();

		$this->addCondition('status','approved');

	}
}