<?php

class page_xHR_page_owner_employeeattendence extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		
		
		$attendence=$this->add('xHR/Model_EmployeeAttendence');
		$crud=$this->app->layout->add('CRUD');
		$crud->setModel($attendence);
		
	}
}