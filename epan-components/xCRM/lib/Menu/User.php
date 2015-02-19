<?php

namespace xCRM;

class Menu_User extends \Menu_Vertical{
	function init(){
		parent::init();
		$this->addItem('Dashboard','xCRM_page_owner_user_dashboard');
		$this->addItem('My Task','xCRM_page_owner_user_mytask');
	}
}