<?php

class page_xDispatch_page_owner_dispatchrequest_toreceive extends page_xDispatch_page_owner_main{

	function page_index(){

		//In DispatchDepartment Request ToReceive according to Status Approved
		$crud=$this->add('CRUD',array('grid_class'=>'xDispatch/Grid_DispatchRequest'));
		$crud->setModel('xDispatch/DispatchRequest_Approved');
		$crud->add('xHR/Controller_Acl');
	}
}
