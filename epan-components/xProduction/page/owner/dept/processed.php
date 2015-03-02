<?php

class page_xProduction_page_owner_dept_processed extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();
		
		$processed_jobcard_model=$this->add('xProduction/Model_Jobcard_Processed');

		if($this->api->stickyGET('department_id'))
			$processed_jobcard_model->addCondition('department_id',$_GET['department_id']);

		$crud=$this->add('CRUD',array('grid_class'=>'xProduction/Grid_JobCard'));
		$crud->setModel($processed_jobcard_model);
		
		if(!$crud->isEditing()){
			$g=$crud->grid;
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));
		}
		

		$crud->add('xHR/Controller_Acl');

	}
}