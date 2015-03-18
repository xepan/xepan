<?php

namespace xStore;

class Model_StockMovement_Draft extends Model_StockMovement{
	function init(){
		parent::init();
		$this->addCondition('status','draft');
	}
}