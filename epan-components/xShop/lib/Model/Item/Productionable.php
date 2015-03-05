<?php

namespace xShop;

class Model_Item_Productionable extends Model_Item{

	function init(){
		parent::init();
		
		$this->addCondition('is_productionable',true);
		
	}
}