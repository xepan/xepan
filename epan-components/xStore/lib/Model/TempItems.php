<?php

namespace xStore;

class Model_TempItems extends \Model {
	
	function init(){
		parent::init();
		
		$this->setSource('Session');

		$this->addField('item_id')->display(array('form'=>'xShop/Item','grid'=>'text'))->setModel('xShop/Item');
		$this->addField('qty');
		$this->addField('unit');
		$this->addField('custom_fields');

	}
}