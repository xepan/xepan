<?php

class page_xProduction_page_owner_outsourceparties extends page_xProduction_page_owner_main{
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Out Source Parties';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Outsource Parties Management <small> Manage your outsource parties </small>');

		$crud=$this->add('CRUD');
		$outsource_model=$this->add('xProduction/Model_OutSourceParty');
		$crud->setModel($outsource_model);
		$crud->grid->addQuickSearch(array('name','code'));
		$crud->grid->addPaginator($ipp=50);
		$crud->grid->add_sno();
		// $jobcard_model=$this->add('xProduction/Model_JobCard');
		// $jobcard=$this->add('xProduction/View_Jobcard');
		// $jobcard->setModel($jobcard_model);
	}

} 