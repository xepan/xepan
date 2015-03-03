<?php

class page_xProduction_page_owner_task_cancelled extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		
		$task = $this->add('xProduction/Model_Task_Cancelled');
		
		$crud=$this->add('CRUD');
		$crud->setModel($task);

		$crud->add('xHR/Controller_Acl');
		
	}
}