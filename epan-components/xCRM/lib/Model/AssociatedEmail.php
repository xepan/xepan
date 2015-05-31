<?php

namespace xCRM;

class Model_AssociatedEmail extends Model_Email{
	function init(){
		parent::init();

		$this->addCondition($this->_dsql()->orExpr()
							->where('from',array('Customer','Supplier','Affiliate','Employee'))
							->where('to',array('Customer','Supplier','Affiliate','Employee'))
							);

		
	}
} 