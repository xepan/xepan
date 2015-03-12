<?php

class page_xDispatch_page_owner_deliverynote_redisgn extends page_xDispatch_page_owner_main{

	function page_index(){

		$crud=$this->add('CRUD');
		$crud->setModel('xDispatch/DeliveryNote_Redesign');
		$crud->add('xHR/Controller_Acl');
	}
}
