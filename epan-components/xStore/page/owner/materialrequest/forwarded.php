<?php

class page_xStore_page_owner_materialrequest_forwarded extends page_xStore_page_owner_main{
	function init(){
		parent::init();

		$model = $this->add('xStore/Model_MaterialRequest_Forwarded');
		$crud=$this->add('CRUD');
		$crud->setModel($model);
		$crud->add('xHR/Controller_Acl');
	}
	
}