<?php

namespace xDispatch;

class Model_DispatchRequest_Submit extends Model_DispatchRequest{
	
	function init(){
		parent::init();

		$this->addCondition('status','submitted');

	}
}