<?php

class page_xHR_page_owner_holidayblock extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small>  Holiday Block </small>');
		$hb=$this->add('xHR/Model_HolidayBlock');
		$crud=$this->add('CRUD');
		$crud->setModel($hb);
		if(!$crud->isEditing()){
			$g=$crud->grid;
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));
		}
	}
}