<?php

namespace xDispatch;

class Model_DispatchRequest_Processing extends Model_DispatchRequest{
	
	function init(){
		parent::init();

		$this->addCondition('status','processing');

	}
}