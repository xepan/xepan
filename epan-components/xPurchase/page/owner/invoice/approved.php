<?php

class page_xPurchase_page_owner_invoice_approved extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$model = $this->add('xPurchase/Model_Invoice_Approved');

		$crud=$this->add('CRUD',array('grid_class'=>'xPurchase/Grid_Invoice'));
		$crud->setModel($model);
		$crud->add('xHR/Controller_Acl');
	}
	
}