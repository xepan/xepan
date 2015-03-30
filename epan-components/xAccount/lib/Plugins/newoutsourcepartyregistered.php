<?php

namespace xAccount;


class Plugins_newoutsourcepartyregistered extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('new_out_source_party_registered',array($this,'new_out_source_party_registered'));
	}

	function new_out_source_party_registered($obj, $out_source_party_model){		
		$group = $this->add('xAccount/Model_Group');
		$group->loadSunderyCreditor();
		$account_model = $this->add('xAccount/Model_Account');
		$account_model->createNewAccount($out_source_party_model,$group,$out_source_party_model['name']);
		
	}
}
