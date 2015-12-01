<?php

namespace xMarketingCampaigns;

class Model_Tele_Followups extends \Model_Document{
	public $tabel = "xmarketingcampaign_tele_followups";
	public $status =[];
	public $root_document_name = 'xMarketingCampaign\Tele_Followups';
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
		$this->hasOne('xMarketingCampaign/Tele_Lead','telelead_id');
		$this->hasOne('xMarketingCampaign/Tele_CampLeadAsso','telecampleadasso_id');

		$this->addField('name')->caption('Narration');
		
		$this->addHook('beforeSave',$this);	
	}


	function beforeSave($this){

		if($this['telecampleadasso_id']){			
			$asso = $this->add('xMarketingCampaign/Model_Tele_CampLeadAsso')->tryLoad($this['telecampleadasso_id']);
			$this['telelead_id'] = $asso['telelead_id'];
			$this['telecampaign_id'] = $asso['telecampaign_id'];
		}
		
	}


}