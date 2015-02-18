<?php

class page_xHR_page_owner_department_document extends page_xHR_page_owner_main {
	
	function init(){
		parent::init();

		$dept_id = $this->api->stickyGET('department_id');

		$dept = $this->add('xHR/Model_Department')->load($dept_id);

		$crud= $this->add('CRUD');
		$crud->setModel($dept->documents());
		if(!$crud->isEditing()){
			$g=$crud->grid;
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));
		}

	}
}