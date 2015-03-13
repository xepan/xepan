<?php
namespace xStore;

class Model_Stock extends \Model_Table{
	public $table="xstore_stock";
	function init(){
		parent::init();

			$this->hasOne('xStore/Warehouse','warehouse_id');	
			$this->hasOne('xShop/Item_Stockable','item_id');	
			$this->addField('qty');
			$this->addField('custom_fields')->type('text')->hint('1(custom_field_id):11(custom_field_value_id) ~ 12(custom_field_id):21(custom_field_value_id)');
			
			// $this->add('dynamic_model/Controller_AutoCreator');
	}
}		
