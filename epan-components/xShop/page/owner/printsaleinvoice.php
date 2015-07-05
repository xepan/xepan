<?php

class page_xShop_page_owner_printsaleinvoice extends Page{

	function init(){
		parent::init();

		
		$css=array(
			'templates/css/noprint.css',
		);
		
		foreach ($css as $css_file) {
			$link = $this->add('View')->setElement('link');
			$link->setAttr('rel',"stylesheet");
			$link->setAttr('type',"text/css");
			$link->setAttr('href',$css_file);
			$link->setAttr('media','print');
		}

		$invoice_id = $this->api->StickyGET('saleinvoice_id');
		if(!$invoice_id) $this->add('View_Warning')->set('Invoice Not Found');

		$invoice = $this->add('xShop/Model_SalesInvoice')->tryload($invoice_id);

		if(!$invoice->loaded()) $this->add('View_Warning')->set('Invoice Not Found');

		echo $link->getHtml();
		echo $invoice->parseEmailBody();
		exit;
	}
}
	
