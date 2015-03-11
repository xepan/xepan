<?php

class page_xDispatch_page_owner_main extends page_componentBase_page_owner_main {
	function initMainPage(){
		//$this->add('H1')->set('Component Owner Main Page');
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Dispatch And Delivery <small> Manage your Dispatch items and order </small>');



	}


	function page_config(){
		$this->add('H1')->set('Default Config Page');
	}
}