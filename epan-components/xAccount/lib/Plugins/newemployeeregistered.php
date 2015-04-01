<?php

namespace xAccount;


class Plugins_newemployeeregistered extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('new_employee_registered',array($this,'new_employee_registered'));
	}

	function new_employee_registered($obj, $employee_model){		
		$group = $this->add('xAccount/Model_Group');
		$group->loadSundryCreditor();

		$account_model = $this->add('xAccount/Model_Account');
		$account_model->createNewAccount($employee_model,$group,$employee_model['name']);

	}
}
