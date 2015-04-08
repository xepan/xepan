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
			
		$f = $this->addField('order_detail_email_subject')->group('c~12~<i class="fa fa-envelope"></i> Order Detail ( Bill ) Email');
		$f->icon = "glyphicon glyphicon-send~blue";  
		$f = $this->addField('order_detail_email_body')->type('text')->caption('Order Detail Email Body')->hint('Order Bill Email Body : this Bill send to member who placed order, {{user_name}},{{mobile_number}},{{billing_address}},{{shipping_address}},{{order_destination}}')->group('c~11')->display(array('form'=>'RichText'));
		$f->icon = "glyphicon glyphicon-send~blue";

		$f = $this->addField('purchase_order_detail_email_subject')->group('d~12~<i class="fa fa-envelope"></i> Purchase Order  Detail ( Bill ) Email');
		$f = $this->addField('purchase_order_detail_email_body')->type('text')->caption('Purchase Order Detail Email Body')->hint('Purchase Order Email Body : this Bill send to Suppliers who placed Purchase order,{{company_name}},{{owner_name}},{{mobile_number}},{{purchase_order_address}},{{supplier_email}},{{supplier_tin_no}},{{supplier_pan_no}},{{purchase_Order_no}},{{purchase_Order_date}}')->group('d~11')->display(array('form'=>'RichText'));

		$f = $this->addField('quotation_email_subject')->group('e~12~<i class="fa fa-envelope"></i>Quotation Order Detail ( Bill ) Email');
		$f = $this->addField('quotation_email_body')->type('text')->caption('Quotation Detail Email Body')->hint('Quotation Order Email Body : this Bill send to Customer who placed Quotation , {{customer_name}},{{mobile_number}},{{address}},{{order_billing_address}},{{order_shipping_address}},{{customer_email}},{{quotation_no}},{{quotation_date}}')->group('e~11')->display(array('form'=>'RichText'));

		$f = $this->addField('invoice_email_subject')->group('e~12~<i class="fa fa-envelope"></i>Invoice Email Mail Subject ( Bill ) Email');
		$f = $this->addField('invoice_email_body')->type('text')->caption('Invoice Email Body')->hint('Invoice  Email Body : this Bill send to Customer who placed order, {{company_name}},{{owner_name}},{{mobile_number}},{{purchase_order_address}},{{supplier_email}},{{supplier_tin_no}},{{supplier_pan_no}},{{purchase_Order_no}},{{purchase_Order_date}}')->group('e~11')->display(array('form'=>'RichText'));
		// TODO GROUP ACCESS of Category and other feature
		// $this->add('dynamic_model/Controller_AutoCreator');
	}
	
}
