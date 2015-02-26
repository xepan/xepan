<?php
namespace xPurchase;

class Model_PurchaseOrderItem extends \Model_Table{
	public $table="xpurchase_purchase_order_item";
	function init(){
		parent::init();

		$this->hasOne('xShop/Item','item_id');
		$this->addField('name');
		$this->addField('qty');
		$this->addField('unit');
		$this->addField('rate')->type('money');
		$this->addField('amount')->type('money');
		$this->addField('custom_fields')->type('text');



		$this->add('dynamic_model/Controller_AutoCreator');

	}
}	