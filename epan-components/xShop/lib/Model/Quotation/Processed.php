<?php

namespace xShop;

class Model_Quotation_Processed extends Model_Quotation{

	function init(){
		parent::init();

		$this->addCondition('status','processed');

	}

	

}