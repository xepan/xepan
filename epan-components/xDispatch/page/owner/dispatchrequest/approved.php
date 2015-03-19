<?php

class page_xDispatch_page_owner_dispatchrequest_approved extends page_xDispatch_page_owner_main{

	function page_index(){

		$crud=$this->add('CRUD');
		$crud->setModel('xDispatch/DispatchRequest_Approved');
		$crud->add('xHR/Controller_Acl');
	}
}
