<?php

class page_xProduction_page_owner_dept_main extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();
		$this->api->stickyGET('department_id');

		$this->app->title=$this->api->current_department['name'] .': JobCards';

		$dept = $this->add('xHR/Model_Department')->load($_GET['department_id']?:$this->api->current_employee->department()->get('id'));

		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '. $dept['name']. '<small> Job Cards :: Manager View</small>');

		$tabs=$this->app->layout->add('Tabs');

		$tabs->addTabURL('xProduction_page_owner_dept_forwardedtohere','Forwarded tO Me');
		$tabs->addTabURL('xProduction_page_owner_dept_received','Received');
		$tabs->addTabURL('xProduction_page_owner_dept_assigned','Assigned');
		$tabs->addTabURL('xProduction_page_owner_dept_processing','Processing');
		$tabs->addTabURL('xProduction_page_owner_dept_processed','Processed');
		$tabs->addTabURL('xProduction_page_owner_dept_approved','Approved');
		$tabs->addTabURL('xProduction_page_owner_dept_forwardedtonext','Forwarded to next');
		$tabs->addTabURL('xProduction_page_owner_dept_completed','Completed');
	}
}