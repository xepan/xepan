<?php
namespace xPurchase;

class Model_PurchaseOrder extends \Model_Table{
	public $table="xpurchase_purchase_order";
	function init(){
		parent::init();


		$this->hasOne('xPurchase/Supplier','xpurchase_supplier_id');
		$this->addField('name')->caption('Item Name');
		$this->addField('qty');
		$this->addField('unit');
		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));

			
			$this->add('dynamic_model/Controller_AutoCreator');
	}
}		
