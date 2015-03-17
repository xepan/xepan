<?php

class page_xStore_page_owner_materialrequestsent_processed extends page_xStore_page_owner_main{
	function init(){
		parent::init();
		$id = $this->api->stickyGET('department_id');
		$model = $this->add('xStore/Model_MaterialRequestSent_Processed');
		$model->addCondition('from_department_id',$id);
		
		$crud=$this->add('CRUD',array('grid_class'=>'xStore/Grid_MaterialRequest'));
		$crud->setModel($model);
		$crud->add('xHR/Controller_Acl');
	}
	
}