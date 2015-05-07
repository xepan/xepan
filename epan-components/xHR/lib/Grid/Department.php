<?php

namespace xHR;
class Grid_Department extends \Grid{
	function init(){
		parent::init();
	}
	function setModel($model){
		$m= parent::setModel($model,array('production_level','name','is_production_department','is_system'));
		
		if($this->hasColumn('is_production_department')) $this->removeColumn('is_production_department');
		if($this->hasColumn('is_system'))$this->removeColumn('is_system');

		$this->addFormatter('name','wrap');

		// $this->fooHideAlways('name');
		// $this->fooToggler('production_level');
		return $m;
	}
	function formatRow(){
		$this->current_row_html['name']=$this->model['name'];
		parent::formatRow();
	}
}