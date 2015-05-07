<?php
namespace xHR;

class Model_EmployeeAttendence extends \Model_Table{
	public $table="xhr_employee_attendence";
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->hasOne('xHR/Employee','employee_id');
		$this->addField('date')->type('date');
		$this->addField('status')->enum(array('present','absent','half_day'));
		
		// $this->add('dynamic_model/Controller_AutoCreator');
		
	}

}