<?php
class page_xMarketingCampaign_page_owner_report extends page_xMarketingCampaign_page_owner_main{
	function init(){
		parent::init();

		$this->add('View_Info')->set('xMarketing Campaign Report');

		$tabs=$this->add('Tabs');
		$tabs->addTabURL('xMarketingCampaign_page_owner_report_lead','Lead');
		$tabs->addTabURL('xMarketingCampaign_page_owner_report_newsletter','NewsLetter');
	}
}