<?php

class page_xProduction_page_owner_dept_main extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();
		$this->api->stickyGET('department_id');

		$this->app->title=$this->api->current_department['name'] .': JobCards';

		$dept = $this->add('xHR/Model_Department')->load($_GET['department_id']?:$this->api->current_employee->department()->get('id'));

		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '. $dept['name']. '<small> Job Cards :: Manager View</small>');

		$tabs=$this->app->layout->add('Tabs');

		$document = $this->add($dept->getNamespace().'/Model_'.  $dept->jobcard_document());

		foreach ($document->status as $st) {
			if($st=='approved'){
				$tabs->addTabURL('xProduction_page_owner_dept_'.$st,'Approved / To Receive');
			}else{
				$tabs->addTabURL('xProduction_page_owner_dept_'.$st,ucwords($st));
			}
		}
	}
}