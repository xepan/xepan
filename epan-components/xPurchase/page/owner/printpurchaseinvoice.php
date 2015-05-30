<?php

class page_xPurchase_page_owner_printpurchaseinvoice extends Page {
		
	function init(){
		parent::init();

		$pi_id = $this->api->StickyGET('purchaseinvoice_id');
		if(!$pi_id) $this->add('View_Warning')->set('Purchase Invoice Not Found');

		$pi = $this->add('xPurchase/Model_PurchaseInvoice')->tryload($pi_id);

		if(!$pi->loaded()) $this->add('View_Warning')->set('Purchase Order Not Found');
		
		echo $pi->parseEmailBody();
		exit;
	}
}