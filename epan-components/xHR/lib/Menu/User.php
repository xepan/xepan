<?php

namespace xHR;

class Menu_User extends \Menu_Vertical{
	function init(){
		parent::init();
		$this->addItem('Dashboard','xHR_page_owner_user_dashboard');
		$this->addItem('My Task','xHR_page_owner_user_mytask');
	}
}