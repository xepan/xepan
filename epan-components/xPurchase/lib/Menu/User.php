<?php

namespace xPurchase;

class Menu_User extends \Menu_Vertical{
	function init(){
		parent::init();
		$this->addItem('Dashboard','xPurchase_page_owner_user_dashboard');
		$this->addItem('My Task','xPurchase_page_owner_user_mytask');
	}
}