<?php

class page_xDispatch_page_owner_dispatchrequest_toreceive extends page_xDispatch_page_owner_main{

	function page_index(){

		//In DispatchDepartment Request ToReceive according to Status Approved
		$disp_req_item = $this->add('xDispatch/Model_DispatchRequestItem')
			->addCondition('status','to_receive');
		$crud=$this->add('CRUD');
		$crud->setModel($disp_req_item);
		$crud->add('xHR/Controller_Acl');
	}
}
