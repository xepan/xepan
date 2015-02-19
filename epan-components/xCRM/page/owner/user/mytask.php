<?php

class page_xCRM_page_owner_user_mytask extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$this->app->layout->add('H1')->set('my all task here');
			}
}