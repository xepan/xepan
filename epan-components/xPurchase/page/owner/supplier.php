<?php
class page_xPurchase_page_owner_supplier extends page_xPurchase_page_owner_main {
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Supplier';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Supplier Manager <small> Manage your supplier </small>');



		$crud=$this->app->layout->add('CRUD');
		$crud->setModel('xPurchase/Model_Supplier');
		
	}
}
