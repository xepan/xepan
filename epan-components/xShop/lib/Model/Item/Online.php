<?php

namespace xShop;

class Model_Item_Online extends Model_Item{

	function init(){
		parent::init();
		
		$this->addCondition('website_display',true);
		
	}
}