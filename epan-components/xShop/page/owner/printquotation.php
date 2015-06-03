<?php

class page_xShop_page_owner_printquotation extends Page{

	function init(){
		parent::init();

		$quotation_id = $this->api->StickyGET('quotation_id');
		if(!$quotation_id) $this->add('View_Warning')->set('Quotation Not Found');

		$quotation = $this->add('xShop/Model_Quotation')->tryload($quotation_id);

		if(!$quotation->loaded()) $this->add('View_Warning')->set('Quotation Not Found');

				
		echo $quotation->parseEmailBody();
		return;
	}
}
	
