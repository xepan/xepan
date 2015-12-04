<?php

class page_xMarketingCampaign_page_owner_telecallingmgnt extends page_xMarketingCampaign_page_owner_main{
	public $title = "TeleCalling Management";

	function init(){
		parent::init();

		$this->add('View_Error')->set('TeleCalling Management Today task for completion');

		$tele_tabs = $this->add('Tabs');
		$tele_tabs->toLeft();
		$tele_tabs->addTabURL('xMarketingCampaign/page/owner/tele_campaign','Campaigns');
		$tele_tabs->addTabURL('xMarketingCampaign/page/owner/tele_followup','Follow-ups');
		$tele_tabs->addTabURL('xMarketingCampaign/page/owner/tele_report','Reports');
		$tele_tabs->addTabURL('xMarketingCampaign/page/owner/tele_setting','Settings');
	}
}