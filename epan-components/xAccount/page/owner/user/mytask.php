<?php

class page_xAccount_page_owner_user_mytask extends page_xAccounts_page_owner_main{
	
	function init(){
		parent::init();

			$this->app->layout->add('View_Error')->set('my All Task Here');

	}
}