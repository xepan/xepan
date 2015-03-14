<?php

class page_xShop_page_owner_user_dashboard extends page_xShop_page_owner_main{
	
	function init(){
		parent::init();
		$this->app->title=$this->api->current_department['name'] .': Dashboard';
		

	}
}