<?php

class page_xHR_page_owner_user_mytask extends page_xHR_page_owner_main{
	
	function init(){
		parent::init();

		$this->app->layout->add('View_Error')->set('my All Task Here');

	}
}