<?php

namespace xCRM;

class Model_OtherEmail extends Model_Email{
	function init(){
		parent::init();

		$this->addCondition($this->_dsql()->orExpr()
							->where('from','<>',array('Customer','Supplier','Affiliate'))
							->where('to','<>',array('Customer','Supplier','Affiliate'))
							);

	}
} 