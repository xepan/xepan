<?php

class Menu_User extends \Menu_Vertical{
	function init(){
		parent::init();
		$this->addItem('Dashboard','xProduction_page_owner_user_dashboard');
		$this->addItem('My Task','xProduction_page_owner_user_tasks');
	}
}