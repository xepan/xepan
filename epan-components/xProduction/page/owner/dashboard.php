<?php

class page_xProduction_page_owner_dashboard extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Dashboard';		

	}
}