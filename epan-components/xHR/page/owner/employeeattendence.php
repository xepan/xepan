<?php

class page_xHR_page_owner_employeeattendence extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		
		$this->app->title=$this->api->current_department['name'] .': Employees Attendance';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Employee Attendance Management <small> Manage employees attendance here </small>');		
		
		$attendence=$this->add('xHR/Model_EmployeeAttendence');
		$crud=$this->app->layout->add('CRUD');
		$crud->setModel($attendence);
		
	}
}