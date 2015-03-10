<?php

class page_xProduction_page_owner_dept_assigned extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();
		
		
		$assigned_jobcard_model=$this->add('xProduction/Model_Jobcard_Assigned');

		if($this->api->stickyGET('department_id'))
			$assigned_jobcard_model->addCondition('to_department_id',$_GET['department_id']);

		$crud=$this->add('CRUD',array('grid_class'=>'xProduction/Grid_JobCard'));
		$crud->setModel($assigned_jobcard_model);
		$crud->add('xHR/Controller_Acl');
	}
}