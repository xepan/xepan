<?php

namespace xAccount;


class Plugins_newsupplierregistered extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('new_supplier_registered',array($this,'new_supplier_registered'));
	}

	function new_supplier_registered($obj, $supplier_model){		
		$group = $this->add('xAccount/Model_Group');
		$group->loadSundryCreditor();
		$account_model = $this->add('xAccount/Model_Account');
		$account_model->createNewAccount($supplier_model,$group,$supplier_model['name']);
		
	}
}
