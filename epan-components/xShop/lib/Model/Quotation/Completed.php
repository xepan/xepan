<?php

namespace xShop;

class Model_Quotation_Completed extends Model_Quotation{

	function init(){
		parent::init();

		$this->addCondition('status','completed');

	}

	

}