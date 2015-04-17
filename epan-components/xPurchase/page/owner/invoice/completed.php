<?php

class page_xPurchase_page_owner_invoice_completed extends page_xPurchase_page_owner_main{
	function init(){
		parent::init();

		$model = $this->add('xPurchase/Model_Invoice_Completed');

		$crud=$this->add('CRUD',array('grid_class'=>'xPurchase/Grid_Invoice'));		
		$crud->setModel($model,array('supplier_id','termsandcondition_id','discount','billing_address','invoiceitem_count'),array('name','invoice_no','po','supplier','total_amount','tax','gross_amount','discount','net_amount','invoiceitem_count'));
		$crud->add('xHR/Controller_Acl');
	}
	
}