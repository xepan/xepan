<?php

namespace xShop;

class Model_Quotation_Processing extends Model_Quotation{

	function init(){
		parent::init();

		$this->addCondition('status','processing');

	}

	

}