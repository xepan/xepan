<?php

class page_owner_documentscategory extends page_base_owner{
	
	function init(){
		parent::init();


		$status=$this->api->stickyGET('status');
		$cat=$this->add('Model_GenericDocumentCategory')->addCondition('status',$status);
		$crud=$this->add('CRUD');
		$crud->setModel($cat);

		$grid=$crud->grid;
		$grid->removeColumn('item_name');
		
	}
}