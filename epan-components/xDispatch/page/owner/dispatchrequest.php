<?php
class page_xDispatch_page_owner_dispatchrequest extends page_xDispatch_page_owner_main {
	function init(){
		parent::init();
		
		$crud=$this->app->layout->add('CRUD');
		$crud->setModel('xDispatch/Model_DispatchRequest');
	}

}