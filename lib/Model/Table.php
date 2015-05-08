<?php

class Model_Table extends SQL_Model {

	function forceDelete($id=null){
		$this->delete($id);
	}

	function hasOne($model,$our_field=null,$display_field=null,$as_field=null,$on_delete='RESTRICT',$on_update="RESTRICT"){
		$r = parent::hasOne($model,$our_field,$display_field,$as_field);
		$r->on_delete = $on_delete;
		$r->on_update = $on_update;
		return $r;
	}
}
