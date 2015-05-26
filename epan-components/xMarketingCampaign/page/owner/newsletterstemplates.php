<?php

class page_xMarketingCampaign_page_owner_newsletterstemplates extends page_xMarketingCampaign_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('xEnquiryNSubscription/NewsLetterTemplate');
	}
}