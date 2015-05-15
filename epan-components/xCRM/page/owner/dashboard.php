<?php

class page_xCRM_page_owner_dashboard extends page_xCRM_page_owner_main {
	function initMainPage(){
		$this->app->title=$this->api->current_department['name'] .': Dashboard';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> xCRM Dashboard <small> Manage your Customer   </small>');
	}


	function page_config(){
		$this->add('H1')->set('Default Config Page');
	}
}