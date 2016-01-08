<?php

namespace xShop;

class Model_Filter extends \Model_Table{
	public $table = "xshop_filters";

	function init(){
		parent::init();

		$this->hasOne('xShop/Category','category_id');
		$this->hasOne('xShop/Item','item_id');
		$this->hasOne('xShop/Specification','specification_id');
		$this->addField('unique_values')->type('text');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}