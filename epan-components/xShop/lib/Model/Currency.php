<?php

namespace xShop;
class Model_Currency extends \Model_Table {
	var $table= "xshop_currency";
	public $root_document_name = 'xShop\Currency';

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->addField('name');
		$this->addField('Value');
		$this->addField('is_default')->type('boolean');

		$this->add('dynamic_model/Controller_AutoCreator');
	}

}