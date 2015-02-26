<?php

namespace xShop;

class Model_Item_Stockable extends Model_Item{

	function init(){
		parent::init();
		
		$this->addCondition('mantain_inventory',true);
		
	}
}