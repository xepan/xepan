<?php

class Model_MyLastSeen extends Model_LastSeen{
	function init(){
		parent::init();
		$this->addCondition('employee_id',$this->api->current_employee->id);
	}
}