<?php

namespace xDispatch;

class Model_DispatchRequest_Completed extends Model_DispatchRequest{
	
	function init(){
		parent::init();

		$this->addCondition('status','complete');

	}
}