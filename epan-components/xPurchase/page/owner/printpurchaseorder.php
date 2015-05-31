<?php

class page_xPurchase_page_owner_printpurchaseorder extends Page {
		
	function init(){
		parent::init();

		$po_id = $this->api->StickyGET('purchaseorder_id');
		if(!$po_id) $this->add('View_Warning')->set('Purchase Order Not Found');

		$po = $this->add('xPurchase/Model_PurchaseOrder')->tryload($po_id);

		if(!$po->loaded()) $this->add('View_Warning')->set('Purchase Order Not Found');
		
		echo $po->parseEmailBody();
		exit;
	}
}