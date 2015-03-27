<?php

class page_xDispatch_page_owner_dispatchrequest_partialcomplete extends page_xDispatch_page_owner_main{

	function page_index(){

		//In DispatchDepartment Request ToReceive according to Status Approved
		$crud=$this->add('CRUD',array('grid_class'=>'xDispatch/Grid_DispatchRequest'));
		$partial_complete = $this->add('xDispatch/Model_DispatchRequest')
						->addCondition('item_under_process','>=',1)
						->addCondition('pending_items_to_deliver',0)
						;

		$crud->setModel($partial_complete,array('order_no','name','created_at','from_department','item_under_process','recent_items_to_receive','pending_items_to_deliver'));
		$crud->add('xHR/Controller_Acl');
	}
}
