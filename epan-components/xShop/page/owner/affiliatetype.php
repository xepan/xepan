<?php

class page_xShop_page_owner_affiliatetype extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		
		$application_id = $this->api->stickyGET('application_id');
		$afflilate_type_model = $this->add('xShop/Model_AffiliateType');
		$afflilate_type_model->addCondition('application_id',$application_id);
		$type_crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_AffiliateType'));

		$type_crud->setModel($afflilate_type_model,array('name'));
		$type_crud->add('xHR/Controller_Acl');
	}
}