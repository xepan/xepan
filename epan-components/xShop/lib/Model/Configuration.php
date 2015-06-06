<?php

namespace xShop;

class Model_Configuration extends \Model_Table {
	var $table= "xshop_configuration";
	function init(){
		parent::init();

		//TODO for Mutiple Epan website
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->hasOne('xShop/Application','application_id');
			
		$f = $this->addField('subject')->caption('Auto Reply Mail Subject')->group('a~12~<i class="fa fa-envelope"></i> Item Enquiry Auto Reply Email');		
		$f->icon = "glyphicon glyphicon-send~blue";  
		$f = $this->addField('message')->type('text')->display(array('form'=>'RichText'))->caption('Auto Reply Mail Message')->group('a~11~dl');		
		$f->icon = "glyphicon glyphicon-send~blue";  
		
		$f = $this->addField('disqus_code')->type('text')->caption('Place the Disqus code')->PlaceHolder('Place your Disqus Code here..')->hint('Place your Discus code here')->group('x~12~<i class="fa fa-comments"></i> Item Comment System Config'); 		
		$f->icon = "fa fa-comment~blue";
			
		$f = $this->addField('add_custom_button')->type('boolean')->hint('Add Custom Button on All Item at Item Detail')->group('b~2~<i class="fa fa-cog"></i> Item Custom Button Options');
		$f->icon = "fa fa-exclamation~blue";
		$f = $this->addField('custom_button_text')->hint('Add Custom Button Text')->group('b~4');
		$f->icon = "fa fa-pencil~blue";
		$f = $this->addField('custom_button_url')->hint('Add Custom Button Redirect Url')->placeHolder('page Url like : registration, home etc.')->group('b~6');
		$f->icon = "fa fa-link~blue";

		//Sales Order Email Subject & Body	
		$f = $this->addField('order_detail_email_subject')->group('c~12~<i class="fa fa-envelope"></i> Order Detail ( Bill ) Email')->hint('Sale Order/Proforma Email Subject: {{order_no}}')->defaultValue('Sale Order/Proforma Email Subject: {{order_no}}');
		$f->icon = "glyphicon glyphicon-send~blue";
		$f = $this->addField('order_detail_email_body')->type('text')->caption('Order Detail Email Body')->hint('Sale Order/Proforma Invoice Bill Email Body : this Bill send to member who placed order, {{customer_name}},{{mobile_number}},{{order_billing_address}},{{customer_email}},{{order_shipping_address}},{{customer_tin_no}},{{customer_pan_no}},{{order_no}},{{order_date}},{{sale_order_details}},{{terms_and_conditions}},{{order_summary}}')->group('c~11')->display(array('form'=>'RichText'));
		$f->icon = "glyphicon glyphicon-send~blue";

		// Purchase Order Email Subject & Body

		$f = $this->addField('purchase_order_detail_email_subject')->group('d~12~<i class="fa fa-envelope"></i> Purchase Order  Detail ( Bill ) Email');
		$f = $this->addField('purchase_order_detail_email_body')->type('text')->caption('Purchase Order Detail Email Body')->hint('Purchase Order Email Body : this Bill send to Suppliers who placed Purchase order,{{company_name}},{{owner_name}},{{mobile_number}},{{purchase_order_address}},{{supplier_email}},{{supplier_tin_no}},{{supplier_pan_no}},{{purchase_Order_no}},{{purchase_Order_date}}')->group('d~11')->display(array('form'=>'RichText'));

		// Quotation Email Subject & Body

		$f = $this->addField('quotation_email_subject')->group('e~12~<i class="fa fa-envelope"></i>Quotation Order Detail ( Bill ) Email');
		$f = $this->addField('quotation_email_body')->type('text')->caption('Quotation Detail Email Body')->hint('Quotation Order Email Body : this Bill send to Customer who placed Quotation , {{customer_name}},{{mobile_number}},{{address}},{{billing_address}},{{shipping_address}},{{customer_email}},{{quotation_no}},{{quotation_date}}')->group('e~11')->display(array('form'=>'RichText'));

		// Sales Invoice Email Subject & Body
		$f = $this->addField('invoice_email_subject')->group('e~12~<i class="fa fa-envelope"></i>Invoice Email Mail Subject ( Bill ) Email');
		$f = $this->addField('invoice_email_body')->type('text')->caption('Sales Invoice Email Body')->hint('Invoice  Email Body : this Bill send to Customer who placed order, {{company_name}},{{owner_name}},{{mobile_number}},{{purchase_order_address}},{{supplier_email}},{{supplier_tin_no}},{{supplier_pan_no}},{{purchase_Order_no}},{{purchase_Order_date}}')->group('e~11')->display(array('form'=>'RichText'));

		// Purchase Invoice Email Subject & Body

		$f = $this->addField('purchase_invoice_email_subject')->group('e~12~<i class="fa fa-envelope"></i> Purchase Invoice Email Mail Subject ( Bill ) Email');
		$f = $this->addField('purchase_invoice_email_body')->type('text')->caption('Purchase Invoice Email Body')->hint('Purchase Invoice  Email Body : this Bill send to Suppliers who placed order, {{company_name}},{{owner_name}},{{mobile_number}},{{purchase_order_address}},{{supplier_email}},{{supplier_tin_no}},{{supplier_pan_no}},{{purchase_Order_no}},{{purchase_Order_date}}')->group('e~11')->display(array('form'=>'RichText'));

		$f = $this->addField('outsource_email_subject')->group('e~12~<i class="fa fa-envelope"></i> OutSource Party Email Mail Subject ( Bill ) Email');
		$f = $this->addField('outsource_email_body')->type('text')->caption('OutSource Party Email Body')
							->hint('OutSource Party  Email Body : this Bill send to OutSource Party who placed order,
							 {{outsource_party}},{{outsource_party_contact_person}},{{outsource_party_contact_no}},{{outsource_party_email_id}},{{outsource_party_address}},{{outsource_party_pan_it_no}},{{outsource_party_tin_no}},{{jobcard_details}},{{Jobcard_no}},{{jobcard_date}}')->group('e~11')->display(array('form'=>'RichText'));
		
		$this->addField('cash_voucher_email_subject');
		$this->addField('cash_voucher_email_body')->type('text')->display(array('form'=>'RichText'));		
		
		$this->addField('quotation_starting_number');
		$this->addField('sale_order_starting_number');
		$this->addField('purchase_order_starting_number');
		$this->addField('sale_invoice_starting_number');
		$this->addField('purchase_invoice_starting_number');

		//Round Amount Calculation
		$this->addField('is_round_amount_calculation')->type('boolean');
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function loadDefaults($application){
		$data= file_get_contents(getcwd().'/epan-components/xShop/default-layouts.xepan');
		$arr = json_decode($data,true);
		foreach ($arr as $dg) {
			unset($dg['id']);
			unset($dg['epan_id']);
			$dg['application_id'] = $application->id;
			$this->newInstance()->set($dg)->save();
		}
	}
	
}
