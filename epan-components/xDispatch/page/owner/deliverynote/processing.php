<?php

class page_xDispatch_page_owner_deliverynote_processing extends page_xDispatch_page_owner_main{

	function page_index(){

		$crud=$this->add('CRUD');
		$crud->setModel('xDispatch/DeliveryNote_Processing');
		$crud->add('xHR/Controller_Acl');
	}
}
