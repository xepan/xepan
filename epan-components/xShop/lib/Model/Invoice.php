<?php

namespace xShop;

class Model_Invoice extends \Model_Document{
	public $table = 'xshop_invoices';
	public $status  = array();
	public $root_document_name = 'xShop\Invoice';
	public $actions=array(
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
		);

	function init(){
		parent::init();
		
		$this->hasOne('xShop/Model_Order','order_id');
		$this->hasOne('xPurchase/Model_PurchaseOrder','po_id');
		$this->addField('type')->enum(array('salesInvoice','purchaseInvoice'));
		$this->addField('billing_address');
		$this->hasMany('xShop/Model_InvoiceItem','invoice_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}
}