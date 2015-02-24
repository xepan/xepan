<?php

namespace xProduction;

class Model_Task extends \Model_Document{
	public $table = "xproduction_tasks";
	public $status=array('assigned','processing','processed','complete','cancel');

	function init(){
		parent::init();

		$this->addField('document_type');
		$this->addField('document_id');

		$this->addField('name')->caption('Subject');
		$this->addField('content')->type('text');

		$this->addField('created_at')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));


		$this->add('dynamic_model/Controller_AutoCreator');
	}

}