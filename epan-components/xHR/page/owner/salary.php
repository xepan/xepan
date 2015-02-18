<?php

class page_xHR_page_owner_salary extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small>  Salary </small>');
		
		$salary=$this->add('xHR/Model_Salary');
		$crud=$this->add('CRUD');
		$crud->setModel($salary);
		if(!$crud->isEditing()){
			$g=$crud->grid;
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));
		}
	}
}