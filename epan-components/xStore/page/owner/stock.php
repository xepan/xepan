<?php
class page_xStore_page_owner_stock extends page_xStore_page_owner_main {
	function init(){
		parent::init();


		$crud=$this->app->layout->add('CRUD');
		$crud->setModel('xStore/Model_Stock');
	}
}
