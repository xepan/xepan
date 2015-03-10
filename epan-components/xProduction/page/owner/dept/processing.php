<?php

class page_xProduction_page_owner_dept_Processing extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();

		$processing_jobcard_model=$this->add('xProduction/Model_Jobcard_Processing');

		if($this->api->stickyGET('department_id'))
			$processing_jobcard_model->addCondition('to_department_id',$_GET['department_id']);

		$crud=$this->add('CRUD',array('grid_class'=>'xProduction/Grid_JobCard'));
		$crud->setModel($processing_jobcard_model);
		$crud->add('xHR/Controller_Acl');


	}
}