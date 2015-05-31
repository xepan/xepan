<?php
class page_xShop_page_owner_invoice_approved extends page_xShop_page_owner_main{
	function init(){
		parent::init();


		$invoice_draft = $this->add('xShop/Model_Invoice_Approved');
		
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Invoice'));
		$crud->setModel($invoice_draft,array('customer_id','termsandcondition_id','discount','billing_address','invoiceitem_count'),array('name','customer','customer_id','invoice_no','sales_order','total_amount','tax','gross_amount','discount','net_amount','invoiceitem_count'));

		// if(!$crud->isEditing()){
		// 	$crud->grid->fooHideBoth('discount');
		// }

		$crud->add('xHR/Controller_Acl');
		
	}
}		