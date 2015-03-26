<?php

class page_xShop_page_owner_invoice extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$invoice = $this->add('xShop/Model_Invoice');
		$crud=$this->app->layout->add('CRUD');
		$crud->setModel($invoice);
		$crud->addref('xShop/Model_InvoiceItem',array('label'=>'Item'));
		$crud->add('xHR/Controller_Acl');
	}

}