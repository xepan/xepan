<?php
namespace xHR;

class Model_EmployeeLeave extends \Model_Table{
	public $table="xhr_employee_leave";
	function init(){
		parent::init();

		$this->addField('name');
		//$this->add('dynamic_model/Controller_AutoCreator');

	}
}