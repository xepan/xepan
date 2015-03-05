<?php

class page_xStore_page_owner_materialrequestreceived_submit extends page_xStore_page_owner_main{
	function init(){
		parent::init();
		$di = $this->api->stickyGET('department_id');
		$model = $this->add('xStore/Model_MaterialRequestReceived_Submit');
		$model->addCondition('to_department_id',$di);
		
		$crud=$this->add('CRUD');
		$crud->setModel($model);
		$crud->add('xHR/Controller_Acl');
	}
	
}