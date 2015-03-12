<?php

class page_xDispatch_page_owner_deliverynote_submit extends page_xDispatch_page_owner_main{

	function page_index(){

		$crud=$this->add('CRUD');
		$crud->setModel('xDispatch/DeliveryNote_Submit');
		$crud->add('xHR/Controller_Acl');
	}
}
