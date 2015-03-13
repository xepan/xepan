<?php
namespace xShop;
class Model_ItemComposition extends \Model_Table{
	public $table="xshop_item_compositions";
	function init(){
		parent::init();

		$this->hasOne('xShop/Item','item_id');
		$this->hasOne('xHR/Department','department_id');
		$this->hasOne('xShop/Item','composition_item_id');

		$this->addField('qty');
		$this->addField('unit');

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function item(){
		return $this->ref('composition_item_id');
	}
}