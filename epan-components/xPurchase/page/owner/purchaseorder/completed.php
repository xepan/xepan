<?php

class page_xPurchase_page_owner_purchaseorder_completed extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$model = $this->add('xPurchase/Model_PurchaseOrder_Completed');

		$crud=$this->add('CRUD',array('grid_class'=>'xPurchase/Grid_PurchaseOrder','add_form_beautifier'=>false));
		$crud->setModel($model,array('supplier_id','priority','order_date','order_summary','orderitem_count'),array('name','supplier','order_date','orderitem_count','priority'));
		$crud->add('xHR/Controller_Acl');
	}
	
}