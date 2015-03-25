<?php

namespace xAccount;


class Plugins_newemployeeregistered extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('new_employee_registered',array($this,'new_employee_registered'));
	}

	function new_employee_registered($obj, $employee_model){		
		$account_model = $this->add('xAccount/Model_Account');
		$account_model['name'] = $employee_model['name'];
		$account_model->save();

	}
}
