<?php

class page_xShop_page_owner_user_mytask extends page_xShop_page_owner_main{
	
	function init(){
		parent::init();

		$this->add('View_Error')->set('my All Task Here');

	}
}