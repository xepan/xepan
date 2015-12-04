<?php

class page_xProduction_page_owner_dept_all extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();

		$jobcard_model=$this->add('xProduction/Model_JobCard');

		if($this->api->stickyGET('department_id'))
			$jobcard_model->addCondition('to_department_id',$_GET['department_id']);

		$crud=$this->add('CRUD',array('grid_class'=>'xProduction/Grid_JobCard'));
		$crud->setModel($jobcard_model);

		$crud->add('xHR/Controller_Acl');
	}
}