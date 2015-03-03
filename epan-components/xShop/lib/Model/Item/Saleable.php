<?php

namespace xShop;

class Model_Item_Saleable extends Model_Item{

	function init(){
		parent::init();
		
		$this->addCondition('is_saleable',true);
		
	}
}