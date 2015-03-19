<?php
class page_xStore_page_owner_stock extends page_xStore_page_owner_main {
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Stock ';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Stock Management <small> Manage stock </small>');



		$crud=$this->app->layout->add('CRUD');
		$crud->setModel('xStore/Model_Stock');
		$crud->grid->addQuickSearch(array('qty'));
		$crud->grid->addPaginator($ipp=50);
	}
}
