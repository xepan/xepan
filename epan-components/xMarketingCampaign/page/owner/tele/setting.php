<?php

class page_xMarketingCampaign_page_owner_tele_setting extends page_xMarketingCampaign_page_owner_main{

	function init(){
		parent::init();

		$this->add('View_Info')->set('TeleCalling Settings');
	}
}