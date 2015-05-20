<?php

class Grid_GenericDocument extends \Grid{
	function init(){
		parent::init();

		$this->addPaginator(50);
	}
	
	function setModel($model,$fields=null){
		if($fields==null){
			$fields = array();
		}

		$m=parent::setModel($model,$fields);
		// if($this->hasColumn('can_create_team'))$this->removeColumn('can_create_team');
		// $this->addFormatter('name','name11');
		return $m;

	}
}