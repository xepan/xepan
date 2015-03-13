<?php
namespace xStore;

class Model_Stock extends \Model_Table{
	public $table="xstore_stock";
	function init(){
		parent::init();

			$this->hasOne('xStore/Warehouse','warehouse_id');	
			$this->hasOne('xShop/Item_Stockable','item_id');	
			$this->addField('qty');
			
			//$this->add('dynamic_model/Controller_AutoCreator');
	}
}		
