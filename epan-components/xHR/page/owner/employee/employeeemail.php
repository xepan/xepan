<?php
class page_xHR_page_owner_employee_employeeemail extends page_xHR_page_owner_main{

	function init(){
		parent::init();

		$emp_id= $this->api->stickyGET('employee_id');

		$emp=$this->add('xHR/Model_Employee')->load($emp_id);
		
		$email=$this->add('xHR/Model_OfficialEmail');
		$email->addCondition('employee_id',$_GET['employee_id']);
		$email->getElement('department_id')->system(true);

		$crud=$this->add('CRUD');
		$crud->setModel($email);

		$crud->add('xHR/Controller_Acl');

	}
}