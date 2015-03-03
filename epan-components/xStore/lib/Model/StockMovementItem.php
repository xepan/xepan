<?php
namespace xStore;
class Model_StockMovementItem extends \Model_Table{
	public $table="xstore_stoc_movement_items";
	function init(){
		parent::init();

		$this->hasOne('xStore/StockMovement','stock_movement_id');
		$this->hasOne('xShop/Item','item_id');
		
		$this->addField('qty');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}