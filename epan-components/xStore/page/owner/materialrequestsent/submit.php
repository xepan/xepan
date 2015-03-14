<?php

class page_xStore_page_owner_materialrequestsent_submit extends page_xStore_page_owner_main{
	function init(){
		parent::init();
		$di = $this->api->stickyGET('department_id');
		$this->add('PageHelp',array('page'=>'materialrequestsent_submit'));
		$model = $this->add('xStore/Model_MaterialRequestSent_Submit');
		$model->addCondition('from_department_id',$di);

		$crud=$this->add('CRUD');
		$crud->setModel($model);
		$crud->add('xHR/Controller_Acl');
	}
	
}