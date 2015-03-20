<?php

class Model_LastSeen extends SQL_Model {
	public $table = "last_seen_updates";

	function init(){
		parent::init();

		$this->hasOne('xHR/Employee','employee_id');

		$this->addField('related_document_id');
		$this->addField('related_root_document_name');
		$this->addField('related_document_name');

		$this->addField('seen_till')->type('datetime')->defaultValue('1970-01-01');

		//$this->add('dynamic_model/Controller_AutoCreator');
	}
}