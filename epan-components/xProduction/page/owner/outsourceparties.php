<?php

class page_xProduction_page_owner_outsourceparties extends page_xProduction_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->app->layout->add('CRUD');
		$outsource_model=$this->add('xProduction/Model_OutSourceParty');
		$crud->setModel($outsource_model);
	}
} 