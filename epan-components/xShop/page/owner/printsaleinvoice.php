<?php

class page_xShop_page_owner_printsaleinvoice extends Page{

	function init(){
		parent::init();

		$invoice_id = $this->api->StickyGET('saleinvoice_id');
		if(!$invoice_id) $this->add('View_Warning')->set('Invoice Not Found');

		$invoice = $this->add('xShop/Model_SalesInvoice')->tryload($invoice_id);

		if(!$invoice->loaded()) $this->add('View_Warning')->set('Invoice Not Found');

		
		echo $invoice->parseEmailBody();
		exit;
	}
}
	
