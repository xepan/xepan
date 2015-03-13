<?php
namespace xPurchase;

class Model_PurchaseOrderItem extends \Model_Table{
	public $table="xpurchase_purchase_order_item";
	function init(){
		parent::init();

		$this->hasOne('xPurchase/PurchaseOrder','po_id');
		
		$this->hasOne('xShop/Item','item_id');
		
		$this->addField('qty');
		$this->addField('unit');
		$this->addField('narration');
		
		$this->addField('custom_fields')->type('text');



		//$this->add('dynamic_model/Controller_AutoCreator');

	}

	function item(){
		return $this->ref('item_id');
	}
}	