<?php
class page_xShop_page_owner_invoice_submitted extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Invoice'));
		$crud->setModel('xShop/Model_Invoice_Submitted');//,array('sales_order_id','customer_id','total_amount','discount','tax','net_amount','billing_address'),array('name','invoice_no','sales_order','total_amount','discount','tax','net_amount'));
		$crud->add('xHR/Controller_Acl');
			
	}
}		