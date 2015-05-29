<?php

namespace xCRM;

class Model_OtherEmail extends Model_Email{
	function init(){
		parent::init();

		$this->addCondition($this->dsql()->andExpr()
							->where($this->dsql()->orExpr()
								->where('from','<>',array('Customer','Supplier','Affiliate','Employee'))
								->where('from',null)
								)
							->where($this->dsql()->orExpr()
								->where('to','<>',array('Customer','Supplier','Affiliate','Employee'))
								->where('to',null)
								)
							);
		$this->debug();
	}
} 