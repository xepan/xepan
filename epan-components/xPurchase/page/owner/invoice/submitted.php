<?php

class page_xPurchase_page_owner_invoice_submitted extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$model = $this->add('xPurchase/Model_Invoice_Submitted');

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Invoice'));
		$crud->setModel($model);
		$crud->add('xHR/Controller_Acl');
	}
	
}