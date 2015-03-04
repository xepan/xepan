<?php

class page_xProduction_page_owner_materialrequirment_submit extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('xProduction/MaterialRequirment_Submit');

		if(!$crud->isEditing()){
			$g=$crud->grid;
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));
		}
		

		$crud->add('xHR/Controller_Acl');


	}
}