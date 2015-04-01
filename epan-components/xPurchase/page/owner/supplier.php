<?php
class page_xPurchase_page_owner_supplier extends page_xPurchase_page_owner_main {
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Supplier';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Supplier Manager <small> Manage your supplier </small>');



		$crud=$this->add('CRUD');
		$crud->setModel('xPurchase/Model_Supplier');
		
		$crud->grid->addQuickSearch(array('name','code','city','state','pin_code','email','contact_no','created_at'));
		$crud->grid->addPaginator($ipp=50);
		$crud->add('xHR/Controller_Acl');
		$crud->grid->add_sno();
	}
}
