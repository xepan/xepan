<?php

namespace xStore;

class Menu_User extends \Menu_Vertical{
	function init(){
		parent::init();
		$this->addItem('Dashboard','xStore_page_owner_user_dsahboard');
		$this->addItem('My Task','xStore_page_owner_user_mytask');
	}
}