<?php

namespace xShop;

class Model_Item_Servicable extends Model_Item{

	function init(){
		parent::init();
		
		$this->addCondition('is_servicable',true);
		
	}
}