<?php

class page_xShop_page_owner_printquotation extends Page{

	function init(){
		parent::init();

		$quotation_id = $this->api->StickyGET('quotation_id');
		if(!$quotation_id) $this->add('View_Warning')->set('Quotation Not Found');

		$quotation = $this->add('xShop/Model_Quotation')->tryload($quotation_id);

		if(!$quotation->loaded()) $this->add('View_Warning')->set('Quotation Not Found');

		$customer = $quotation->customer();
		$customer_email=$customer->get('customer_email');

		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
				
		$email_body=$config_model['quotation_email_body']?:"Quotation Layout Is Empty";
		
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$email_body = str_replace("{{customer_name}}", $customer['customer_name'], $email_body);
		$email_body = str_replace("{{mobile_number}}", $customer['mobile_number'], $email_body);
		$email_body = str_replace("{{address}}",$customer['address'], $email_body);
		$email_body = str_replace("{{billing_address}}",$customer['billing_address'], $email_body);
		$email_body = str_replace("{{shipping_address}}",$customer['shipping_address'], $email_body);
		$email_body = str_replace("{{customer_email}}", $customer['customer_email'], $email_body);
		$email_body = str_replace("{{quotation_no}}", $quotation['name'], $email_body);
		$email_body = str_replace("{{quotation_date}}", $quotation['created_at'], $email_body);
		//END OF REPLACING VALUE INTO ORDER DETAIL EMAIL BODY
		
		echo $email_body;
		return;
	}
}
	
