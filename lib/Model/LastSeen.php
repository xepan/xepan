<?php

class Model_LastSeen extends SQL_Model {
	public $table = "last_seen_updates";

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xHR/Employee','employee_id');

		$this->addField('related_document_id');
		$this->addField('related_root_document_name');
		$this->addField('related_document_name');

		// Last seen till is last created at document timestamp
		$this->addField('seen_till')->type('datetime')->defaultValue('1970-01-01');
		$this->addHook('beforeDelete',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');
	}


	function beforeDelete(){}
	
	function forceDelete(){
		$this->delete();
	}
	
}