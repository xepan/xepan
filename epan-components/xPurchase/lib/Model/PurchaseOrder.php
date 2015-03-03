<?php
namespace xPurchase;

class Model_PurchaseOrder extends \Model_Table{
	public $table="xpurchase_purchase_order";
	function init(){
		parent::init();


		$this->hasOne('xPurchase/Supplier','supplier_id');

		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		

		$this->hasMany('xPurchase/PurchaseOrderItem','po_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}		
