<?php

namespace xShop;

class Model_Item_Downloadable extends Model_Item{

	function init(){
		parent::init();
		
		$this->addCondition('is_downloadable',true);
		
	}
}