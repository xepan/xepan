<?php

namespace xStore;
class Model_MaterialRequestItem extends \Model_Document{
	public $table="xstore_material_request_items";
	public $status=array();
	public $root_document_name='xStore\MaterialRequestItem';

	function init(){
		parent::init();

		$this->hasOne('xStore/MaterialRequest','material_request_id');
		$this->hasOne('xShop/Item','item_id');
		
		$this->addField('qty');

		$this->add('dynamic_model/Controller_AutoCreator');

	}

	function item(){
		return $this->ref('item_id');
	}
}