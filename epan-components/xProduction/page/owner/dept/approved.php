<?php

class page_xProduction_page_owner_dept_approved extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();

		$approved_jobcard_model=$this->add('xProduction/Model_Jobcard_Approved');

		if($this->api->stickyGET('department_id'))
			$approved_jobcard_model->addCondition('to_department_id',$_GET['department_id']);

		$crud=$this->add('CRUD',array('grid_class'=>'xProduction/Grid_JobCard'));
		$crud->setModel($approved_jobcard_model);

		$p=$crud->addFrame('Details', array('icon'=>'plus'));
		if($p){
			$p->add('xProduction/View_Jobcard',array('jobcard'=>$this->add('xProduction/Model_JobCard')->load($crud->id)));
		}

		$crud->add('xHR/Controller_Acl');

	



	}
}