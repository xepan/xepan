<?php


namespace xHR;

class Model_Document extends \SQL_Model {
	public $table= "xhr_documents";

	function init(){
		parent::init();
			
			$this->hasOne('xHR/Department','department_id');
			$this->addField('name');

			$this->hasMany('xHR/DepartmentAcl','document_id');

	}

}