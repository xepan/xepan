<?php

class page_xMarketingCampaign_page_owner_newsletterscat extends page_xMarketingCampaign_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('xEnquiryNSubscription/NewsLetterCategory',array('name','posts'));
	}
}