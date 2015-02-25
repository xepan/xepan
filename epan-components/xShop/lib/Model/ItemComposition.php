<?php
namespace xShop;
class Model_ItemComposition extends \Model_Table{
	public $table="xshop_item_compositions";
	function init(){
		parent::init();

		$this->hasOne('xShop/Item','item_id');
		$this->hasOne('xShop/Item','composition_item_id');

		$this->addField('qty');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}