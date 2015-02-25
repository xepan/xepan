<?php

namespace xProduction;

class Model_Task extends \Model_Document{
	public $table = "xproduction_tasks";
	public $status=array('assigned','processing','processed','complete','cancel');
	public $root_document_name = "Task";

	function init(){
		parent::init();

		$this->addField('root_document_name');
		$this->addField('document_name');
		$this->addField('document_id');

		$this->addField('name')->caption('Subject');
		$this->addField('content')->type('text');
		$this->addField('Priority')->enum(array('low','Medium','High','Urgent'));

		$this->addField('expected_start_date')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));
		$this->addField('expected_end_date')->type('datetime')->defaultValue(date('Y-m-d H:i:s'));

		$this->add('dynamic_model/Controller_AutoCreator');
	}

}