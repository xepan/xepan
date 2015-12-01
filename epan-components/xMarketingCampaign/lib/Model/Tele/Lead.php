<?php

namespace xMarketingCampaign;


class Model_Tele_Lead extends Model_Lead {
	public $status=array();
	public $root_document_name="xMarketingCampaign\Tele_Lead";

	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_start_processing'=>array('caption'=>'Create Opportunity','icon'=>'users'),
			'can_manage_attachments'=>false,
			'can_see_activities'=>array(),
		);

	function init(){
		parent::init();

		// $this->hasOne('Epan','epan_id');
		// $this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->hasOne('xMarketingCampaign/Tele_Campaign','telecampaign_id');

		// $this->addField('name')->sortable(true);
		$this->hasMany('xMarketingCampaign/Tele_CampLeadAsso','telelead_id');
		
		$this->add('dynamic_model/Controller_AutoCreator');
	}
	
}