<?php
namespace xHR;

class Model_EmployeeAttendence extends \Model_Table{
	public $table="xhr_employee_attendence";
	function init(){
		parent::init();

		//$this->hasOne('xHR/Employee',)
		$this->addField('name');
		//$this->add('dynamic_model/Controller_AutoCreator');

	}
}