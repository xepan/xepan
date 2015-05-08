<?php


namespace xHR;

class Model_Document extends \Model_Table {
	public $table= "xhr_documents";

	function init(){
		parent::init();
			
			$this->hasOne('Epan','epan_id');
			$this->addCondition('epan_id',$this->api->current_website->id);

			$this->hasOne('xHR/Department','department_id');
			$this->addField('name');

			$this->hasMany('xHR/DocumentAcl','document_id');

	}

	function modelName($str=null){
		if(!$str) $str= $this['name'];
		$name = $str;
		$name = explode("\\", $name);
		$name = $name[0].'\\Model_'.$name[1];
		return $name;
	}

	function department(){
		return $this->ref('department_id');
	}

	function forceDelete(){
		$this->ref('xHR/DocumentAcl')->each(function($dacl){
			$dacl->forceDelete();
		});

		$this->delete();
	}

}