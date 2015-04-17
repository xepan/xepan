<?php
class page_xShop_page_owner_invoice_submitted extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Invoice'));
		$crud->setModel('xShop/Model_Invoice_Submitted',array('customer_id','termsandcondition_id','discount','billing_address','invoiceitem_count'),array('name','customer','invoice_no','sales_order','total_amount','tax','gross_amount','discount','net_amount','invoiceitem_count'));
		$crud->add('xHR/Controller_Acl');
			
	}
}		