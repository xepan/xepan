<?php

namespace xAccount;

class Menu_User extends \Menu_Vertical{
	function init(){
		parent::init();
		$this->addItem('Dashboard','xAccount_page_owner_user_dashboard');
		$this->addItem('My Task','xAccount_page_owner_user_mytask');
	}
}