<?php

class page_xHR_page_owner_main extends page_componentBase_page_owner_main {
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small> Your Human Capital at a glance</small>');
	}


	function page_config(){
		$this->add('H1')->set('Default Config Page');
	}
}