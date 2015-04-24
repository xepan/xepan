<?php

class page_xShop_page_owner_printsaleinvoice extends Page{

	function init(){
		parent::init();

		$invoice_id = $this->api->StickyGET('saleinvoice_id');
		if(!$invoice_id) $this->add('View_Warning')->set('Invoice Not Found');

		$invoice = $this->add('xShop/Model_SalesInvoice')->tryload($invoice_id);

		if(!$invoice->loaded()) $this->add('View_Warning')->set('Invoice Not Found');

		$sale_invoice_detail=$this->add('xShop/View_SalesInvoiceDetail');
		$sale_invoice_detail->setModel($invoice->itemrows());
		
		$tnc=$invoice->termAndCondition();

		$customer = $invoice->customer();
		$customer_email=$customer->get('customer_email');

		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
				
		$email_body=$config_model['invoice_email_body']?:"Sale Invoice Layout Is Empty";
		
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$email_body = str_replace("{{customer_name}}", $customer['customer_name'], $email_body);
		$email_body = str_replace("{{mobile_number}}", $customer['mobile_number']?"Contact No.:".$customer['mobile_number'].",":" ", $email_body);
		$email_body = str_replace("{{city}}", $customer['city']? $customer['city']:" ", $email_body);
		$email_body = str_replace("{{state}}", $customer['state']?", ".$customer['state']:" ", $email_body);
		$email_body = str_replace("{{country}}", $customer['country']?", ".$customer['country']:" ", $email_body);
		$email_body = str_replace("{{order_billing_address}}",$customer['billing_address']?"Address.:".$customer['billing_address']:" ", $email_body);
		$email_body = str_replace("{{order_shipping_address}}",$customer['shipping_address']?"Shipping Address.:".$customer['shipping_address']:" ", $email_body);
		$email_body = str_replace("{{customer_email}}", $customer['customer_email']?"Email.:".$customer['customer_email']:" ", $email_body);
		$email_body = str_replace("{{customer_tin_no}}", $customer['tin_no']?"TIN No.:".$customer['tin_no']:" ", $email_body);
		$email_body = str_replace("{{customer_pan_no}}", $customer['pan_no']?"PAN No.:".$customer['pan_no']:" ", $email_body);
		$email_body = str_replace("{{invoice_details}}", $sale_invoice_detail->getHtml(), $email_body);
		$email_body = str_replace("{{invoice_order_no}}", $invoice['name'], $email_body);
		$email_body = str_replace("{{invoice_date}}", $invoice['created_at'], $email_body);
		$email_body = str_replace("{{dispatch_challan_no}}", "", $email_body);
		$email_body = str_replace("{{dispatch_challan_date}}", "", $email_body);
		$email_body = str_replace("{{terms_an_conditions}}", $tnc['terms_and_condition']?"<b>Terms & Condition.:</b><br>".$tnc['terms_and_condition']:" ", $email_body);

		echo $email_body;
		exit;
	}
}
	
