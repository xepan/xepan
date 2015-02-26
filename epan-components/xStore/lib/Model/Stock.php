<?php
namespace xStore;

class Model_Stock extends \Model_Table{
	public $table="xstore_stock";
	function init(){
		parent::init();

			$this->hasOne('xShop/Item_Stockable','item_id');	
			$this->hasOne('xHR/Department','department_id');	
			$this->add('dynamic_model/Controller_AutoCreator');
	}
}		
