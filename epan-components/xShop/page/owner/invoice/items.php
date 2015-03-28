<?php

class page_xShop_page_owner_invoice_items extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$invoice_id=$this->api->stickyGET('xshop_invoices_id');
		
		$item_model = $this->add('xShop/Model_InvoiceItem');
		$item_model->addCondition('invoice_id',$invoice_id);
		
		$item_crud=$this->add('CRUD');
		$item_crud->setModel($item_model);
		$item_crud->add('xHR/Controller_Acl');
	}
}