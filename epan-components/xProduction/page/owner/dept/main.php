<?php

class page_xProduction_page_owner_dept_main extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small> '. $this->department['name'] .'</small>');

		$tabs=$this->app->layout->add('Tabs');

		$tabs->addTabURL('xProduction_page_owner_dept_forwarded','Forwarded tO Me');
		$tabs->addTabURL('xProduction_page_owner_dept_received','Received');
		$tabs->addTabURL('xProduction_page_owner_dept_assigned','Assigned');
		$tabs->addTabURL('xProduction_page_owner_dept_processing','Processing');
		$tabs->addTabURL('xProduction_page_owner_dept_processed','Processed');
		$tabs->addTabURL('xProduction_page_owner_dept_approved','Approved');
		$tabs->addTabURL('xProduction_page_owner_dept_forwardedtonext','Forwarded to next');
		$tabs->addTabURL('xProduction_page_owner_dept_completed','Completed');
	}
}