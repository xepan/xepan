<?php
class page_xShop_page_owner_invoice_completed extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Invoice'));
		$crud->setModel('xShop/Model_Invoice_Completed',array('customer_id','termsandcondition_id','discount','shipping_charge','billing_address','invoiceitem_count','narration','created_at'),array('name','customer_id','customer','sales_order','total_amount','tax','gross_amount','discount','net_amount','invoiceitem_count','shipping_charge','created_at','updated_at','updated_date','created_date'));
		$crud->add('xHR/Controller_Acl');
		
		$crud->grid->addPaginator($ipp=100);	
	}
}		