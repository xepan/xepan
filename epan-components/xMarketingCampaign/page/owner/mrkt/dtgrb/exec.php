<?php


class page_xMarketingCampaign_page_owner_mrkt_dtgrb_exec extends page_componentBase_page_owner_main {

	function init(){
		parent::init();
		$this->app->title=$this->api->current_department['name'] .': Data Grabbing';
		$this->add('xMarketingCampaign/Controller_DataGrabberExec');

	}

}