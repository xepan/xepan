<?php

class page_xPurchase_page_owner_printpurchaseorder extends Page {
		
	function init(){
		parent::init();

		$print_order_array = [];

		if($_GET['printAll']){
			//For multi Print
			$print_order  = $this->add('xPurchase/Model_PurchaseOrder');

            if($_GET['from_date'])
                $print_order->addCondition('created_at','>=',$_GET['from_date']);
            
            if($_GET['to_date'])
                $print_order->addCondition('created_at','<=',$_GET['to_date']);
            
            if($_GET['supplier_id'])
                $print_order->addCondition('supplier_id',$_GET['supplier_id']);
            
            if($_GET['status'])
                $print_order->addCondition('status',$_GET['status']);

            $all_order = $print_order->_dsql()->del('fields')->field('id')->getAll();
           	$print_order_array = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($all_order)),false);
		
		}else{
			//For Single Purchase Order Print
			$print_order_array[] = $order_id = $this->api->StickyGET('purchaseorder_id');
		}

		foreach ($print_order_array as $key => $order_id) {

				if(!$order_id) {
					$this->add('View_Warning')->set('Purchase Order Not Found');
					return;
				}
				$po = $this->add('xPurchase/Model_PurchaseOrder')->tryload($order_id);
				echo $po->parseEmailBody();
		}
		
		exit; 


		// $po_id = $this->api->StickyGET('purchaseorder_id');
		// if(!$po_id) $this->add('View_Warning')->set('Purchase Order Not Found');

		// $po = $this->add('xPurchase/Model_PurchaseOrder')->tryload($po_id);

		// if(!$po->loaded()) $this->add('View_Warning')->set('Purchase Order Not Found');
		
		// echo $po->parseEmailBody();
		// exit;

	}
}