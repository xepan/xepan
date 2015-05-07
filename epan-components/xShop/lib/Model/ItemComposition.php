<?php
namespace xShop;
class Model_ItemComposition extends \Model_Table{
	public $table="xshop_item_compositions";
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->hasOne('xShop/Item','item_id');
		$this->hasOne('xHR/Department','department_id');
		$this->hasOne('xShop/Item','composition_item_id')->display(array('form'=>'xShop/Item'));

		$this->addField('qty');
		$this->addField('unit');
		$this->addField('custom_fields')->type('text');

		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function item(){
		return $this->ref('composition_item_id');
	}
}