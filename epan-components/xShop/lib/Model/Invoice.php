<?php

namespace xShop;

class Model_Invoice extends \Model_Document{
	public $table = 'xshop_invoices';
	public $status  = array('draft','submitted','approved','canceled','completed');
	public $root_document_name = 'xShop\Invoice';
	public $actions=array(
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
		);

	function init(){
		parent::init();

		
		$this->hasOne('xShop/OrderDetails','orderitem_id')->sortable(true);
		$this->hasOne('xShop/Model_Order','sales_order_id');
		$this->hasOne('xPurchase/Model_PurchaseOrder','po_id')->caption('Purchase Order');
		$this->addField('type')->enum(array('salesInvoice','purchaseInvoice'));
		$this->addField('name')->caption('Invoice No');
		$this->addField('customer_name');
		$this->addField('mobile_no');
		$this->addField('amount');
		$this->addField('discount');
		$this->addField('tax');
		$this->addField('net_amount');
		$this->addField('billing_address')->type('text');
		$this->hasMany('xShop/InvoiceItem','invoice_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function itemrows(){
		return $this->ref('xShop/InvoiceItem');
	}
	function orderItem(){
		if(!$this['orderitem_id']){
			return false;
		}
		return $this->ref('orderitem_id');
	}
}