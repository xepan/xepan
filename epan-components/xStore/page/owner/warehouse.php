<?php
class page_xStore_page_owner_warehouse extends page_xStore_page_owner_main {
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Warehouse';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Warehouse Management <small> warehouse </small>');



		$crud=$this->app->layout->add('CRUD');
		$crud->setModel('xStore/Model_Warehouse');
		$crud->addRef('xStore/Stock');
		
		$crud->grid->addQuickSearch(array('name'));
		$crud->grid->addPaginator($ipp=50);
	}
}