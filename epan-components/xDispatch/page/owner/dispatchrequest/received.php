<?php

class page_xDispatch_page_owner_dispatchrequest_received extends page_xDispatch_page_owner_main{

	function page_index(){

		$crud=$this->add('CRUD',array('grid_class'=>'xDispatch/Grid_DispatchRequest'));
		$crud->setModel('xDispatch/DispatchRequest');
		$crud->add('xHR/Controller_Acl');

	}
}
