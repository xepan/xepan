<?php
class page_xHR_page_owner_leave_leaveallocation extends page_xHR_page_owner_main{
	function init(){
		parent::init();

		$emp_leave=$this->add('xHR/Model_EmployeeLeave');
		$crud=$this->add('CRUD');
		$crud->setModel($emp_leave);
	}
}