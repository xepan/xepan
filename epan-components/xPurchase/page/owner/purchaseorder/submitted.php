<?php

class page_xPurchase_page_owner_purchaseorder_submitted extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$model = $this->add('xPurchase/Model_PurchaseOrder_Submitted');

		$crud=$this->add('CRUD',array('grid_class'=>'xPurchase/Grid_PurchaseOrder','add_form_beautifier'=>false));
		$crud->setModel($model,array('supplier_id','priority','order_date','order_summary','orderitem_count'),array('name','supplier','order_date','orderitem_count','priority'));
		$crud->add('xHR/Controller_Acl');

		$this->add('xPurchase/View_PurchaseOrder',array('purchaseorder'=>$this->add('xPurchase/Model_PurchaseOrder')->load(1)));
	}
	
}