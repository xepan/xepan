<?php

class page_xProduction_page_owner_task_draft extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		
		
		$draft = $this->add('xProduction/Model_Task_Draft');
		$crud=$this->add('CRUD');
		$crud->setModel($draft,array('employee','team','name','subject','Priority','expected_end_date'));
		$crud->add('xHR/Controller_Acl');
		
	}


}