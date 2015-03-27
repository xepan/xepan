<?php
class page_xShop_page_owner_invoice_completed extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('xShop/Model_Invoice_Completed');
		$crud->add('xHR/Controller_Acl');
		
	}
}		