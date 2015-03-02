<?php

class page_xStore_page_owner_materialrequest_assigned extends page_xStore_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('xStore/Model_MaterialRequest_Assigned');
	}
}