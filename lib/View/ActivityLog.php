<?php

class View_ActivityLog extends View {
	function init(){
		parent::init();
			
		$grid = $this->add('Grid_ActivityLog');
		$grid->setModel('xCRM/Model_Activity')->setOrder('id','desc');
		$grid->addPaginator($ipp=10);
	}



}