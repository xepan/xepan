<?php

class page_xStore_page_owner_materialrequestsent_toreceive extends page_xStore_page_owner_main{
	function init(){
		parent::init();
		$di = $this->api->stickyGET('department_id');
		$model = $this->add('xStore/Model_MaterialRequestSent_ToReceive');
		$model->addCondition('from_department_id',$di);

		$crud=$this->add('CRUD',array('grid_class'=>'xStore/Grid_MaterialRequest'));
		$crud->setModel($model);
		$crud->add('xHR/Controller_Acl');
	}
	
}