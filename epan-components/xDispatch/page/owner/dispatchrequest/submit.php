<?php

class page_xDispatch_page_owner_dispatchrequest_submit extends page_xDispatch_page_owner_main{

	function page_index(){

		$crud=$this->add('CRUD',array('grid_class'=>'xDispatch/Grid_DispatchRequest'));
		$crud->setModel('xDispatch/DispatchRequest_Submit');
		$crud->add('xHR/Controller_Acl');
	}
}
