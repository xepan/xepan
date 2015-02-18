<?php

namespace xProduction;

class Menu_User extends \Menu_Vertical{
	function init(){
		parent::init();
		$this->addItem('Dashboard','xProduction_page_owner_user_dashboard');
		$this->addItem('JobCards','xProduction_page_owner_user_jobcards');
	}
}