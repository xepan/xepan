<?php

class page_xProduction_page_owner_materialrequirment_ayushi extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();

	$crud =	$this->app->layout->add('CRUD');
		$crud->setModel('xProduction/MaterialRequirment_Ayushi');
		
	}
}