<?php

namespace xStore;

class Model_StockMovement_Accepted extends Model_StockMovement{
	function init(){
		parent::init();
		$this->addCondition('status','accepted');
	}
}