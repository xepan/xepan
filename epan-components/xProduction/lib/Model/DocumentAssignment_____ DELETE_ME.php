<?php

namespace xProduction;

class Model_DocumentAssignment extends \SQL_Model{
	public $table ="xproduction_document_assignments";

	function init(){
		parent::init();

		$this->hasOne('xHR/Model_Document','document_id');
		$this->hasOne('xHR/Model_Employee','employee_id');
		$this->hasOne('xProduction/Model_Team','team_id');

		$this->addField('root_document_name');
		$this->addField('document_name');
		
		//$this->add('dynamic_model/Controller_AutoCreator');

	}
}	