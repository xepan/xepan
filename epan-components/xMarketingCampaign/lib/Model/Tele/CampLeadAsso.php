<?php

namespace xMarketingCampaign;


class Model_Tele_CampLeadAsso extends \Model_Document {
	public $table ='xmarketingcampaign_tele_campaign_lead_asso';

	function init(){
		parent::init();
		
		$this->hasOne('xMarketingCampaign/Tele_Campaign','telecampaign_id');
		$this->hasOne('xMarketingCampaign/Tele_Lead','telelead_id')->display(array('form'=>'autocomplete/Plus'))->caption('TeleCalling Lead')->sortable(true);

		// $this->addField('name')->sortable(true);
		
		$this->add('dynamic_model/Controller_AutoCreator');
	}
	
}