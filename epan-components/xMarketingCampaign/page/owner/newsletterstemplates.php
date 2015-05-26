<?php

class page_xMarketingCampaign_page_owner_newsletterstemplates extends page_xMarketingCampaign_page_owner_main{
	function init(){
		parent::init();

		$m= $this->add('xEnquiryNSubscription/Model_NewsLetterTemplate');

		if($_GET['getjson']){
			echo json_encode($m->getRows());
			exit;
		}

		$crud=$this->add('CRUD');
		$crud->setModel($m);
	}
}