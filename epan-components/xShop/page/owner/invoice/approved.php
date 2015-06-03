<?php
class page_xShop_page_owner_invoice_approved extends page_xShop_page_owner_main{
	function init(){
		parent::init();


		$invoice_draft = $this->add('xShop/Model_Invoice_Approved');
		
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Invoice'));
		$crud->setModel($invoice_draft,array('customer_id','termsandcondition_id','discount','shipping_charge','billing_address','invoiceitem_count','created_at'),array('name','customer','customer_id','sales_order','total_amount','tax','gross_amount','discount','net_amount','invoiceitem_count','shipping_charge'));

		// if(!$crud->isEditing()){
		// 	$crud->grid->fooHideBoth('discount');
		// }

		$crud->add('xHR/Controller_Acl');
		
	}
}		