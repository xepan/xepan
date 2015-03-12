<?php

class page_xDispatch_page_owner_deliverynote_completed extends page_xDispatch_page_owner_main{

	function page_index(){

		$crud=$this->add('CRUD');
		$crud->setModel('xDispatch/DeliveryNote_Completed');
		$crud->add('xHR/Controller_Acl');
	}
}
