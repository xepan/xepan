<?php
namespace xProduction;

class Grid_Task extends \Grid{

	function init(){
		parent::init();
		$self= $this;
		$this->addSno();

	
	}
	
	
	function setModel($task_model){
		$m=parent::setModel($task_model,array('name','created_at','from_department'));
		return $m;
	}
}