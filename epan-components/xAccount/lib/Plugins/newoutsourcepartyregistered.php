<?php

namespace xAccount;


class Plugins_newoutsourcepartyregistered extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('new_out_source_party_registered',array($this,'new_out_source_party_registered'));
	}

	function new_out_source_party_registered($obj, $out_source_party_model){		
		$account_model = $this->add('xAccount/Model_Account');
		$account_model['name'] = $out_source_party_model['name'];
		$account_model->save();

	}
}
