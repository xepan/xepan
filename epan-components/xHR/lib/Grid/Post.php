<?php
namespace xHR;

class Grid_Post extends \Grid{
	function init(){
		parent::init();

	}
	
	function setModel($model,$fields=null){
		if($fields==null){
			$fields = array('parent_post_id','name','is_active','can_create_team');
		}

		$m=parent::setModel($model,$fields);
		if($this->hasColumn('is_active'))$this->removeColumn('is_active');
		if($this->hasColumn('employees'))$this->removeColumn('employees');
		if($this->hasColumn('can_create_team'))$this->removeColumn('can_create_team');
		// $this->addFormatter('name','name11');
		return $m;
	}


	function formatRow(){

		// $this->
		if(!$this->model['is_active']){
			$this->current_row_html['name'] = '<div title=" In Active Post ( '.$this->model['name'].' ) Employees ( '.$this->model['employees'].') ">'.$this->model['name'].'<span class="pull-right">Create Team<i class=" atk-swatch-red badge icon-cancel"> </i></span> <span class="badge icon-users pull-right"> '.$this->model['employees'].' </span></div>';
			$this->setTdParam('name','class','atk-effect-danger');
		}else{
			$this->setTdParam('name','class','');
			$this->current_row_html['name'] = '<div title=" Active Post ( '.$this->model['name'].' ) Employees ( '.$this->model['employees'].') ">'.$this->model['name'].'<span class="pull-right">Create Team<i class=" atk-swatch-green badge icon-ok"> </i></span> <span class="badge icon-users pull-right"> '.$this->model['employees'].' </span></div>';
		}


		parent::formatRow();
	}
}