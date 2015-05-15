<?php
class page_xPurchase_page_owner_supplier extends page_xPurchase_page_owner_main {
	function init(){
		parent::init();
		$this->app->title=$this->api->current_department['name'] .': Supplier';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Supplier Manager <small> Manage your supplier </small>');

		$crud=$this->add('CRUD',array('grid_class'=>'xPurchase/Grid_Supplier'));
		$crud->setModel('xPurchase/Model_Supplier',array('name','owner_name','city','contact_person_name',
														'accounts_person_name','code','address','state',
														'pin_code','fax_number','contact_no','email','tin_no','pan_no','is_active'
														),array());
		
		$crud->add('xHR/Controller_Acl');
		
		
  
	}
}