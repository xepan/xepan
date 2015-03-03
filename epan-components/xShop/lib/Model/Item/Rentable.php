<?php

namespace xShop;

class Model_Item_Rentable extends Model_Item{

	function init(){
		parent::init();
		
		$this->addCondition('is_rentable',true);
		
	}
}