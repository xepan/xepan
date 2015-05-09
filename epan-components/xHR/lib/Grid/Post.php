<?php
namespace xHR;

class Grid_Post extends \Grid{
	function init(){
		parent::init();

		$this->addPaginator(30);
		$this->addQuickSearch(array('name','employees','parent_post'));
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

	function recursiveRender(){
		$this->addFormatter('edit','edit');
		$this->addFormatter('delete','delete');

		parent::recursiveRender();
	}

	function format_edit(){
		if($this->current_row['name']=="Director")
			$this->current_row_html['edit']='';
	}

	function format_delete(){
		if($this->current_row['name']=="Director")
			$this->current_row_html['delete']='';

	}

	function formatRow(){
		// $this->
		$can_create_team = "No";
		if($this->model['can_create_team']) $can_create_team = "Yes";
		
		if(!$this->model['is_active']){

			$str = '<div title=" In Active Post ( '.$this->model['name'].' ) Employees ( '.$this->model['employees'].')  Create Team ( '.$can_create_team.' )">'.$this->model['name'];
			if($this->model['can_create_team'])
				$str .= '<span class="pull-right atk-effect-success">Create Team<i class="atk-swatch-green badge icon-ok"> </i>';
			else
				$str .= '<span class="pull-right">Create Team<i class="atk-swatch-red badge icon-cancel"> </i>';

			$str.='</span><span class="badge icon-users pull-right">'.$this->model['employees'].'</span></div>';
			
			$this->current_row_html['name'] = $str;
			$this->setTdParam('name','class','atk-effect-danger');
		}else{
			$str = '<div title=" Active Post ( '.$this->model['name'].' ) Employees ( '.$this->model['employees'].')  Create Team ( '.$can_create_team.' ) ">'.$this->model['name'];
			if($this->model['can_create_team'])
				$str .= '<span class="pull-right atk-effect-success">Create Team<i class="atk-swatch-green badge icon-ok"> </i>';
			else
				$str .= '<span class="atk-effect-danger pull-right">Create Team<i class="atk-swatch-red badge icon-cancel"> </i>';

			$str.='</span> <span class="badge icon-users pull-right"> '.$this->model['employees'].' </span></div>';
			
			$this->current_row_html['name'] = $str;
			$this->setTdParam('name','class','');

			// $this->current_row_html['name'] = '<div title=" Active Post ( '.$this->model['name'].' ) Employees ( '.$this->model['employees'].') ">'.$this->model['name'].
			// '<span class="pull-right">Create Team<i class=" atk-swatch-green badge icon-ok"> </i></span> <span class="badge icon-users pull-right"> '.$this->model['employees'].' </span></div>';
		}


		parent::formatRow();
	}
}