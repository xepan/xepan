<?php

namespace xShop;

class Model_BlogApplication extends Model_Application {
	function init(){
		parent::init();
		$this->addCondition('type','Blog');
	}



}