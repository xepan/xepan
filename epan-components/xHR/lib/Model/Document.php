<?php


namespace xHR;

class Model_Document extends \SQL_Model {
	public $table= "xhr_documents";

	function init(){
		parent::init();
			
			$this->hasOne('Epan','epan_id');
			$this->addCondition('epan_id',$this->api->current_website->id);
			$this->hasOne('xHR/Department','department_id');
			$this->addField('name');

			$this->hasMany('xHR/DepartmentAcl','document_id');

	}

	function modelName(){
		$name = $this['name'];
		$name = explode("\\", $name);
		$name = $name[0].'\\Model_'.$name[1];
		return $name;
	}

	function department(){
		return $this->ref('department_id');
	}

}