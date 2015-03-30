<?php

namespace xAccount;

class Plugins_newuserregistered extends \componentBase\Plugin{
	public $namespace = 'xAccount';

	function init(){
		parent::init();

		$this->addHook('new_user_registered',array($this,'new_user_registered'));
	}

	function new_user_registered($obj,$user_model){
		$group = $this->add('xAccount/Model_Group');
		$group->loadSunderyCreditor();
		$account_model = $this->add('xAccount/Model_Account');
		$account_model->createNewAccount($user_model,$group,$user_model['name']);
		
	}

}

