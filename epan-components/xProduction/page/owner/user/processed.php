<?php

class page_xProduction_page_owner_user_processed extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();
		


		$crud=$this->add('CRUD',array('grid_card'=>'xProduction/Grid_JobCard','allow_add'=>false,'allow_del'=>false,'allow_edit'=>false));
		$crud->setModel($this->app->current_employee->processedJobCards());
		if(!$crud->isEditing()){
			$g=$crud->grid;
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));
		}


	
	}
}