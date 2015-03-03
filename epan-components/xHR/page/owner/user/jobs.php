<?php

class page_xHR_page_owner_user_jobs extends page_xHR_page_owner_main{
	
	function init(){
		parent::init();

		$this->app->layout->add('View_Error')->set('my All Jobs Here');

	}
}