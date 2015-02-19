<?php

namespace xMarketingCampaign;

class Menu_User extends \Menu_Vertical{
	function init(){
		parent::init();
		$this->addItem('Dashboard','xMarketingCampaign_page_owner_user_dashboard');
		$this->addItem('My Leads','xMarketingCampaign_page_owner_user_myleads');
		$this->addItem('My Task','xMarketingCampaign_page_owner_user_mytask');
	}
}