<?php

class page_xPurchase_page_owner_printpurchaseinvoice extends Page {
		
	function init(){
		parent::init();

		$pi_id = $this->api->StickyGET('purchaseinvoice_id');
		if(!$pi_id) $this->add('View_Warning')->set('Purchase Invoice Not Found');

		$pi = $this->add('xPurchase/Model_PurchaseInvoice')->tryload($pi_id);

		if(!$pi->loaded()) $this->add('View_Warning')->set('Purchase Order Not Found');
		
		$pi_details=$this->add('xPurchase/View_PurchaseInvoiceDetail');
		$pi_details->setModel($pi->itemrows());
		
		$tnc=$pi->termAndCondition();

		$supplier = $pi->supplier();
		$supplier_email=$supplier->get('email');

		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
				
		$email_body=$config_model['purchase_invoice_email_body']?:"Purchase Invoice Layout Is Empty";
		
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$email_body = str_replace("{{purchase_invoice_details}}", $pi_details->getHtml(), $email_body);
		$email_body = str_replace("{{company_name}}", $supplier['name'], $email_body);
		$email_body = str_replace("{{owner_name}}", $supplier['owner_name']?$supplier['owner_name']:" ", $email_body);
		$email_body = str_replace("{{supplier_code}}", $supplier['code']?$supplier['code']:" ", $email_body);
		$email_body = str_replace("{{mobile_number}}", $supplier['contact_no']?$supplier['contact_no']:" ", $email_body);
		$email_body = str_replace("{{purchase_order_address}}",$supplier['address']?$supplier['address']:" ", $email_body);
		$email_body = str_replace("{{supplier_email}}", $supplier['email'], $email_body);
		$email_body = str_replace("{{supplier_tin_no}}", $supplier['tin_no']?$supplier['tin_no']:" - ", $email_body);
		$email_body = str_replace("{{supplier_pan_no}}", $supplier['pan_no']?$supplier['pan_no']:" - ", $email_body);
		$email_body = str_replace("{{purchase_Order_no}}", $pi['name'], $email_body);
		$email_body = str_replace("{{purchase_Order_date}}", $pi['created_at'], $email_body);
		$email_body = str_replace("{{terms_an_conditions}}", $tnc['terms_and_condition']?$tnc['terms_and_condition']:" ", $email_body);

		echo $email_body;
		exit;
	}
}