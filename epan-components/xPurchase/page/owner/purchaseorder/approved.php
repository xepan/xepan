<?php

class page_xPurchase_page_owner_purchaseorder_approved extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$model = $this->add('xPurchase/Model_PurchaseOrder_Approved');

		$crud=$this->add('CRUD',array('grid_class'=>'xPurchase/Grid_PurchaseOrder','add_form_beautifier'=>false));
		$crud->setModel($model);
		$crud->add('xHR/Controller_Acl');
	}
	
}