<?php

class page_xShop_page_owner_invoice_items extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$invoice_id=$this->api->stickyGET('xshop_invoices_id');
		
		$item_model = $this->add('xShop/Model_InvoiceItem');
		$item_model->addCondition('invoice_id',$invoice_id);
		
		$item_crud=$this->add('CRUD');
		$item_crud->setModel($item_model,array('item_name','item_id','custom_fields','qty','rate','amount','apply_tax','narration'),array('item_name','item','qty','rate','amount','tax_per_sum','tax_amount','texted_amount','narration'));
		if(!$item_crud->isEditing()){
			$item_crud->grid->removeColumn('item');
		}

		$item_crud->add('xShop/Controller_getRate');
		$item_crud->add('xHR/Controller_Acl');
	}
}