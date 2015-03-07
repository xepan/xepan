<?php

class page_xHR_page_owner_employeeleave extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		$this->app->title=$this->api->current_department['name'] .': Emp Leaves';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Employee Leave Management <small> Manage employees leaves </small>');		
		
		$leave=$this->add('xHR/Model_EmployeeLeave');
		$crud=$this->app->layout->add('CRUD');
		$crud->setModel($leave);
		
	}
}