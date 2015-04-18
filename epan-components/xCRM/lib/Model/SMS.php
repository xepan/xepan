<?php

namespace xCRM;

class Model_SMS extends \Model_Document {
	public $table = 'xcrm_smses';
	public $status = array();
	public $root_document_name='xCRM\SMS';

	function init(){
		parent::init();

		$this->addField('name')->caption('Mobile Number');
		$this->addField('message');

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function send(){
		
	}
}