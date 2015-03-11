<?php

namespace xDispatch;

class Model_DispatchRequest_Redesign extends Model_DispatchRequest{
	
	function init(){
		parent::init();

		$this->addCondition('status','redesign');

	}
}