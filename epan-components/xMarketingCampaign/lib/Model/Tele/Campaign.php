<?php

namespace xMarketingCampaign;


class Model_Tele_Campaign extends \Model_Document {
	public $table ='xmarketingcampaign_tele_campaigns';
	public $status = [];
	public $root_document_name = 'xMarketingCampaign\Tele_Campaign';
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_see_activities'=>array()
		);

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->addField('name')->sortable(true);

		$this->hasMany('xMarketingCampaign/Tele_CampLeadAsso','telecampaign_id');
		// $this->hasMany('xMarketingCampaign/Tele_Lead','telecampaign_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
	

	function leads(){
		if(!$this->loaded())
			throw new \Exception("Tele campaign must be loaded before getting all associated leads");
		
		$lead_model = $this->add('xMarketingCampaign/Model_Tele_Lead');
		$lead_model_j = $lead_model->join('xmarketingcampaign_tele_campaign_lead_asso.telelead_id');
		$lead_model_j->addField('telecampaign_id');
		$lead_model->addCondition('telecampaign_id',$this->id);
		return $lead_model->tryLoadAny();

	}

}