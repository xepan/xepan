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
		
		$this->addFormatter('name','name11');
		return $m;
	}


	function format_name11(){

		$inactive_class="atk-effect-danger"; 
		if(!$this->model['is_active'])
			$inactive_class = "atk-effect-danger";
		$this->current_row_html['name']=123;
		// parent::formatRow();							
	}
}