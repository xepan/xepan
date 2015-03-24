<?php
namespace xStore;
class Model_StockMovementItem extends \Model_Table{
	public $table="xstore_stock_movement_items";
	function init(){
		parent::init();

		$this->hasOne('xStore/StockMovement','stock_movement_id')->sortable(true);
		$this->hasOne('xShop/Item','item_id')->sortable(true)->display(array('form'=>'xShop/Item'));
		
		$this->addField('qty')->mandatory(true);
		$this->addField('custom_fields')->type('text');

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function item(){
		return $this->ref('item_id');
	}
}