<?php

class page_xShop_page_owner_dashboard extends page_xShop_page_owner_main{

	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Dashboard';

		$this->app->layout->add('View_Info')->set('Dashboard...cooming sooon..');
	}
}		