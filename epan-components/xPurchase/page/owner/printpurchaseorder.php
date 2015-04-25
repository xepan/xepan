<?php

class page_xPurchase_page_owner_printpurchaseorder extends Page {
		
	function init(){
		parent::init();

		$po_id = $this->api->StickyGET('purchaseorder_id');
		if(!$po_id) $this->add('View_Warning')->set('Purchase Order Not Found');

		$po = $this->add('xPurchase/Model_PurchaseOrder')->tryload($po_id);

		if(!$po->loaded()) $this->add('View_Warning')->set('Purchase Order Not Found');
		
		$po_details =$this->add('xPurchase/View_PurchaseOrderDetail');
		$po_details->setModel($po->itemrows());		
		
		$supplier = $po->supplier();
		$supplier_email=$supplier->get('email');

		$config_model=$this->add('xShop/Model_Configuration');
		$config_model->tryLoadAny();
				
		$email_body=$config_model['purchase_order_detail_email_body']?:"Purchase Order Layout Is Empty";
	
		// $email_body = $print_order->getHTML(false);
		//REPLACING VALUE INTO ORDER DETAIL TEMPLATES
		$email_body = str_replace("{{purchase_order_details}}", $po_details->getHtml(), $email_body);
		$email_body = str_replace("{{company_name}}", $supplier['name']?$supplier['name']:" ", $email_body);
		$email_body = str_replace("{{owner_name}}", $supplier['owner_name']?$supplier['owner_name']:" ", $email_body);
		$email_body = str_replace("{{supplier_code}}", $supplier['code']?$supplier['code']:" ", $email_body);
		$email_body = str_replace("{{mobile_number}}", $supplier['contact_no']?$supplier['contact_no']:" ", $email_body);
		$email_body = str_replace("{{supplier_email}}", $supplier['email']?$supplier['email']:" ", $email_body);
		$email_body = str_replace("{{purchase_order_address}}",$supplier['address']?$supplier['address']:" ", $email_body);
		$email_body = str_replace("{{supplier_tin_no}}", $supplier['tin_no']?$supplier['tin_no']:" - ", $email_body);
		$email_body = str_replace("{{supplier_pan_no}}", $supplier['pan_no']?$supplier['pan_no']:" - ", $email_body);
		$email_body = str_replace("{{purchase_order_no}}", $po['name'], $email_body);
		$email_body = str_replace("{{purchase_order_date}}", $po['created_at'], $email_body);
		$email_body = str_replace("{{delivery_to}}", $po['delivery_to'], $email_body);

		echo $email_body;
		exit;
	}
}