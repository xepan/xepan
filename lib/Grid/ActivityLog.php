<?php

class Grid_ActivityLog extends \xGrid{
	public $ipp=10;
	public $grid_template='xactivitylog';

	// function setModel($task_model){
		
	// }

	function formatRow(){
		parent::formatRow();		
	}

	function defaultTemplate(){
		return array($this->grid_template);
	}

}