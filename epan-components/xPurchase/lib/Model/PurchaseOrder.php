<?php
namespace xPurchase;

class Model_PurchaseOrder extends \Model_Document{
	public $table="xpurchase_purchase_order";
	public $status=array('draft','approved','rejected','submitted');
	public $root_document_name='xStore\PurchaseOrder';
	function init(){
		parent::init();


		$this->hasOne('xPurchase/Supplier','supplier_id');

		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		

		$this->hasMany('xPurchase/PurchaseOrderItem','po_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}		
