<?php
class page_xShop_page_owner_invoice_approved extends page_xShop_page_owner_main{
	function init(){
		parent::init();


		$invoice_draft = $this->add('xShop/Model_Invoice_Approved');
		
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Invoice'));
		$crud->setModel($invoice_draft);

		if(!$crud->isEditing()){
		}

		$crud->add('xHR/Controller_Acl');
		
	}
}		