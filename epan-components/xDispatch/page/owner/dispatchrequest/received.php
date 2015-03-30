<?php

class page_xDispatch_page_owner_dispatchrequest_received extends page_xDispatch_page_owner_main{

	function page_index(){

		$crud=$this->add('CRUD',array('grid_class'=>'xDispatch/Grid_DispatchRequest'));
		$crud->setModel('xDispatch/DispatchRequest_Received',array('order_no','name','created_at','from_department','item_under_process','recent_items_to_receive','pending_items_to_deliver'));
		$crud->add('xHR/Controller_Acl');

	}
}
