<?php

namespace xShop;

class Model_Item_Purchasable extends Model_Item{

	function init(){
		parent::init();
		
		$this->addCondition('is_purchasable',true);
		
	}
}