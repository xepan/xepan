<?php

namespace xDispatch;

class Model_DispatchRequest_Assigned extends Model_DispatchRequest{
	
	function init(){
		parent::init();

		$this->addCondition('status','assigned');

	}
}