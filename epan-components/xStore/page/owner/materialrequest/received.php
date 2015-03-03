<?php

class page_xStore_page_owner_materialrequest_received extends page_xStore_page_owner_main{
	function init(){
		parent::init();
		$store = $this->add('xHR/Model_Department')->loadBy('related_application_namespace','xStore');

		$model = $this->add('xStore/Model_MaterialRequest_Received');
		$model->addCondition('department_id',$store->id);
		$crud=$this->add('CRUD');
		$crud->setModel($model);
		$crud->add('xHR/Controller_Acl');
		$crud->add('xHR/Controller_Acl');
	}
	
}