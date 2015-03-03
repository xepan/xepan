<?php

namespace xStore;
class Model_MaterialRequestItem extends \Model_Table{
	public $table="xstore_material_request_items";
	function init(){
		parent::init();

		$this->hasOne('xStore/MaterialRequest','material_request_id');
		$this->hasOne('xShop/Item','item_id');
		
		$this->addField('qty');

		$this->add('dynamic_model/Controller_AutoCreator');

	}
}