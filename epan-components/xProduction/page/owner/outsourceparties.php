<?php

class page_xProduction_page_owner_outsourceparties extends page_xProduction_page_owner_main{
	function init(){
		parent::init();

		$this->app->title="Production" .': Out Source Parties';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Outsource Parties Management <small> Manage your outsource parties </small>');

		$crud=$this->add('CRUD',array('grid_class'=>'xProduction/Grid_OutSourceParty'));
		$outsource_model=$this->add('xProduction/Model_OutSourceParty');
		$crud->setModel($outsource_model);

	}

} 