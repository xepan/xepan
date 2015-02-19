<?php

namespace xEnquiryNSubscription;

class Menu_User extends \Menu_Vertical{
	function init(){
		parent::init();
		$this->addItem('Dashboard','xEnquiryNSubscription_page_owner_user_dashboard');
		$this->addItem('My Task','xEnquiryNSubscription_page_owner_user_mytask');
	}
}