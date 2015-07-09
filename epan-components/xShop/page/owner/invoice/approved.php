<?php
class page_xShop_page_owner_invoice_approved extends page_xShop_page_owner_main{
	function init(){
		parent::init();


		$invoice_draft = $this->add('xShop/Model_Invoice_Approved');
		
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Invoice'));
		
		// if($crud->isEditing()){
		// 	$invoice_draft->getElement('created_at')->system(false)->visible(true)->editable(true);
		// }

		$crud->setModel($invoice_draft,array('customer_id','termsandcondition_id','discount','created_at','shipping_charge','billing_address','invoiceitem_count','narration'),array('name','customer','customer_id','sales_order','total_amount','tax','gross_amount','discount','net_amount','invoiceitem_count','shipping_charge','created_at','updated_at','updated_date','created_date'));
		$crud->add('xHR/Controller_Acl');
		
		$crud->grid->addPaginator($ipp=50);	
	}
}		