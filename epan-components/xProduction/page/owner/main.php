<?php

class page_xProduction_page_owner_main extends page_componentBase_page_owner_main {
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small> Your Work Flow Management</small>');
	}



	function page_config(){
		$this->add('H1')->set('Default Config Page');
	}
}