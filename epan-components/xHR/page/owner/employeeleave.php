<?php

class page_xHR_page_owner_employeeleave extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		
		
		$leave=$this->add('xHR/Model_EmployeeLeave');
		$crud=$this->app->layout->add('CRUD');
		$crud->setModel($leave);
		
	}
}