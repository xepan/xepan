<?php

namespace xAccount;

class Plugins_newuserregistered extends \componentBase\Plugin{
	public $namespace = 'xAccount';

	function init(){
		parent::init();

		$this->addHook('new_user_registered',array($this,'new_user_registered'));
	}

	function new_user_registered($obj,$user_model){

		$account_model = $this->add('xAccount/Model_Account');
		// $account_model['member_id'] = $user_model->getMember();
		$account_model['name'] = $user_model['name'];
		$account_model->save();
	}

}
