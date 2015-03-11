<?php

class page_xDispatch_page_owner_dispatchrequest_Processed extends page_xDispatch_page_owner_main{

	function page_index(){

		$crud=$this->add('CRUD');
		$crud->setModel('xDispatch/DispatchRequest_Processed');
		$crud->add('xHR/Controller_Acl');
	}
}
