<?php

class Model_Document extends SQL_Model{
	
	public $status = null;
	public $document_name=null;
	public $root_document_name=null;

	function init(){
		parent::init();

		if($this->status === null)
			throw $this->exception('Document Status property must be defined as array');

		if(count($this->status))
			$this->addField('status')->enum($this->status);

		if($this->root_document_name == null)
			throw $this->exception('Root Document Name Must Be defined');

		if($this->document_name == null){
			$class_name = get_class($this);
			$class_name = explode('\\', $class_name);
			if(count($class_name)==2) 
				$class_name=$class_name[1];
			else
				$class_name=$class_name[0];

			$this->document_name = str_replace("Model_", "", $class_name);
		}

		$this->hasOne('xHR/Employee','created_by_id')->defaultValue($this->api->current_employee->id)->system(true);

	}

	function assignTo($to){

	}

	function assignToTeam($team){
		
	}

	function assignToEmployee($employee){
		
	}
}