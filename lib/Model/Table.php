<?php

class Model_Table extends SQL_Model {

	function init(){
		parent::init();

		$this->addHook('afterLoad',function($obj){
			$obj->data_original = $obj->data;
		});

		$this->addHook('afterSave',function($obj){
			if($obj->recall('CachedData',false)) $obj->forget("CachedData");
		});
	}

	function forceDelete($id=null){
		$this->delete($id);
	}

	function hasOne($model,$our_field=null,$display_field=null,$as_field=null,$on_delete='RESTRICT',$on_update="RESTRICT"){
		$r = parent::hasOne($model,$our_field,$display_field,$as_field);
		$r->on_delete = $on_delete;
		$r->on_update = $on_update;
		return $r;
	}

	function getCached($cond, $get_scalar_field=null){
		$data = $this->recall("CachedData",$this->newInstance()->getRows());
		if(!is_array($cond)) throw $this->exception('Condition must ab an array of field=> value');
		

		foreach ($data as $datum) {
			$found=true;
			foreach ($cond as $field => $value) {
				if($datum[$field]!=$value){
					$found = false;
					continue 2;
				}
			}
			if(!$found) return array();
			if($get_scalar_field) return $datum[$get_scalar_field];
			return $datum;
		}
	}
}
