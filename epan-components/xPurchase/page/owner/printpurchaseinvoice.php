<?php

class page_xPurchase_page_owner_printpurchaseinvoice extends Page {
		
	function init(){
		parent::init();

		$print_invoice_array=[];
		if($_GET['printAll']){

			$print_invoice=$this->add('xPurchase/Model_PurchaseInvoice');

				if($_GET['from_date'])
                $print_order->addCondition('created_at','>=',$_GET['from_date']);
            	if($_GET['to_date'])
                $print_order->addCondition('created_at','<=',$_GET['to_date']);
            	if($_GET['supplier_id'])
                $print_order->addCondition('supplier_id',$_GET['supplier_id']);
            	if($_GET['order_id'])
                $print_order->addCondition('order_id',$_GET['order_id']);
            	if($_GET['status'])
                $print_order->addCondition('status',$_GET['status']);

	            $all_order = $print_invoice->_dsql()->del('fields')->field('id')->getAll();
	           	$print_invoice_array = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($all_order)),false);
				
			}else{
				$print_invoice_array[] = $invoice_id = $this->api->StickyGET('purchaseinvoice_id');

		}

		foreach ($print_invoice_array as $key => $invoice_id){
			//var_dump($print_invoice_array);
			
			if(!$invoice_id){
				$this->add('View_Warning')->set('Purchase Invoice Not Found');
				return;
			} 
			$pi = $this->add('xPurchase/Model_PurchaseInvoice')->tryload($invoice_id);
			echo $pi->parseEmailBody();
		}

		exit;

		/*$pi_id = $this->api->StickyGET('purchaseinvoice_id');
		if(!$pi_id) $this->add('View_Warning')->set('Purchase Invoice Not Found');

		$pi = $this->add('xPurchase/Model_PurchaseInvoice')->tryload($pi_id);

		if(!$pi->loaded()) $this->add('View_Warning')->set('Purchase Order Not Found');
		
		echo $pi->parseEmailBody();
		exit;*/
	}
}