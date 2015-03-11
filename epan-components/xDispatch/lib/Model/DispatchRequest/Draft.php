<?php

namespace xDispatch;

class Model_DispatchRequest_Draft extends Model_DispatchRequest{
	
	function init(){
		parent::init();

		$this->addCondition('status','draft');

	}
}