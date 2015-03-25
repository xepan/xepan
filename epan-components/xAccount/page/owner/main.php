<?php

class page_xAccount_page_owner_main extends page_componentBase_page_owner_main {
	function initMainPage(){
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small> Your Account Managment</small>');
		
	}

	function page_config(){
		$this->add('H1')->set('Default Config Page');
	}
}