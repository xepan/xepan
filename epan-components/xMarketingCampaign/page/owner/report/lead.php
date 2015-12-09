<?php

class page_xMarketingCampaign_page_owner_report_lead extends page_xMarketingCampaign_page_owner_main{
	function init(){
		parent::init();

		$this->add('View_Error')->set('xMarketing Campaign Lead Report');
	}
}