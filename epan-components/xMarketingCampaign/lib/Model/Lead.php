<?php

namespace xMarketingCampaign;

class Model_Lead extends \xEnquiryNSubscription\Model_Subscription{
	// public $table="xmarketingcampaign_leads";
	public $status=array();
	public $root_document_name="xMarketingCampaign\Lead";

	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
		);
	
	function init(){
		parent::init();
		$this->getElement('from_app')->defaultValue('Manual Feed');
	}
}