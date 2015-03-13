<?php
namespace xPurchase;
class Model_PurchaseMaterialRequestItem extends \Model_Table{
	public $table="xpurchase_purchase_material_request_items";
	function init(){
		parent::init();

		$this->hasOne('xPurchase/PurchaseMaterialRequest','purchase_material_request_id');
		$this->hasOne('xShop/Item','item_id');

		$this->addField('qty');

		//$this->add('dynamic_model/Controller_AutoCreator');
	}
}