<?php


class page_xShop_page_owner_afflilate extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Affiliate';		
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Affiliate Management <small> Manage item Affiliates like brands/publishers/authors etc. </small>');
		$application_id=$this->api->recall('xshop_application_id');

		$afflilate_model = $this->add('xShop/Model_Affiliate');
		$afflilate_model->addCondition('application_id',$application_id);
		$aff_crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Affiliate'));
		$aff_crud->setModel($afflilate_model);

		$aff_crud->add('xHR/Controller_Acl');

	}
}

		
