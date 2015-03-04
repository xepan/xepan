<?php

class page_xProduction_page_owner_materialrequirment extends page_xProduction_page_owner_main{
	function init(){
		parent::init();
		$tabs=$this->app->layout->add('Tabs');
		$tabs->addTabURL('xProduction_page_owner_materialrequirment_draft','Draft');
		$tabs->addTabURL('xProduction_page_owner_materialrequirment_submit','Submitted');
		$tabs->addTabURL('xProduction_page_owner_materialrequirment_approved','Approved');
		$tabs->addTabURL('xProduction_page_owner_materialrequirment_reject','Rejected/Redesign');
	
		// $model=$this->setModel('xProduction/MaterialRequirment_MaterialRequirment');
		// $crud=$this->app->layout->add('CRUD');
		// $crud->setModel($model);

	}
} 