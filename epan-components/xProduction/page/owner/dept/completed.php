<?php

class page_xProduction_page_owner_dept_completed extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();
		
		$crud=$this->add('CRUD',array('grid_class'=>'xProduction/Grid_JobCard'));
		$crud->setModel('xProduction/Jobcard_Completed');
		if(!$crud->isEditing()){
			$g=$crud->grid;
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));
		}
		

		$crud->add('xHR/Controller_Acl');

	}
}