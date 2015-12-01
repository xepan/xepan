<?php

namespace xMarketingCampaign;


class Model_Tele_CampLeadAsso extends \Model_Document {
	public $table ='xmarketingcampaign_tele_campaign_lead_asso';
	public $status = [];
	public $root_document_name = 'xMarketingCampaign\Tele_CampLeadAsso';
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_see_activities'=>array()
		);


	function init(){
		parent::init();
		
		$this->hasOne('xMarketingCampaign/Tele_Campaign','telecampaign_id');
		$this->hasOne('xMarketingCampaign/Tele_Lead','telelead_id')->display(array('form'=>'autocomplete/Plus'))->caption('TeleCalling Lead')->sortable(true);

		// $this->addField('name')->sortable(true);
		$this->hasMany('xMarketingCampaign/Tele_Followups','telecampleadasso_id');	
		$this->add('dynamic_model/Controller_AutoCreator');
	}
	
}