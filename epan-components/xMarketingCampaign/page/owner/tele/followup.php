<?php

class page_xMarketingCampaign_page_owner_tele_followup extends page_xMarketingCampaign_page_owner_main{

	function init(){
		parent::init();

		$this->add('View_Info')->set('TeleCalling Followups management');
	}
}