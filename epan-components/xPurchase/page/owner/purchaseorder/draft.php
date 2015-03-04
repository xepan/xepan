<?php

class page_xPurchase_page_owner_purchaseorder_draft extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$model = $this->add('xPurchase/Model_PurchaseOrder_Draft');

		$crud=$this->add('CRUD');
		$crud->setModel($model);
		$crud->addRef('xPurchase/PurchaseOrderItem');
		$crud->add('xHR/Controller_Acl');

	}

	
}