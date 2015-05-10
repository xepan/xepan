<?php

namespace xHR;
class Grid_Employee extends \Grid{
	function init(){
		parent::init();
	}
	function setModel($model){
		$m= parent::setModel($model,array('name','post_id','post','department_id','department','user_id','user'));
		
		if($this->hasColumn('post')) $this->removeColumn('post');
		if($this->hasColumn('post_id')) $this->removeColumn('post_id');
		if($this->hasColumn('department'))$this->removeColumn('department');
		if($this->hasColumn('department_id'))$this->removeColumn('department_id');
		if($this->hasColumn('user'))$this->removeColumn('user');
		if($this->hasColumn('user_id'))$this->removeColumn('user_id');

		// $this->addFormatter('name','wrap');

		// $this->fooHideAlways('name');
		// $this->fooToggler('production_level');
		return $m;
	}
	function formatRow(){
		// $this->current_row_html['name']=$this->model['post']."klfgkhj ". $this->model['department_id'];
		parent::formatRow();
	}
}