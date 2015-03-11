<?php

namespace xDispatch;

class Model_DispatchRequest_Processed extends Model_DispatchRequest{
	
	function init(){
		parent::init();

		$this->addCondition('status','processed');

	}
}