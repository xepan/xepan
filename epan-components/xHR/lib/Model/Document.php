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

	function loadDefaults($new_departments_with_ids){
		$filename = getcwd().'/epan-components/xHR/default-documents.xepan';
		$data= file_get_contents($filename);
		$arr = json_decode($data,true);
		foreach ($arr as $dg) {
			unset($dg['id']);
			unset($dg['epan_id']);
			$dg['department_id'] = $new_departments_with_ids[$dg['department']];
			if(!$dg['department_id']) continue;
			
			$this->newInstance()->set($dg)->save();
		}
	}

	function getDefaults(){
		$filename = getcwd().'/epan-components/xHR/default-documents.xepan';
		$data= file_get_contents($filename);
		$arr = json_decode($data,true);
		return $arr;
	}

	function saveDefaults(){
		$filename = getcwd().'/epan-components/xHR/default-documents.xepan';
		$d= $this->add('xHR/Model_Document');
		$arr = $d->getRows();
		file_put_contents($filename, json_encode($arr));
	}

}