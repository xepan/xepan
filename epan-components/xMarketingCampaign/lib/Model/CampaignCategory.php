<?php

namespace xMarketingCampaign;


class Model_CampaignCategory extends \Model_Table {
	public $table ='xmarketingcampaign_campaigns_categories';

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->addField('name')->sortable(true);

		$this->addExpression('campaigns')->set(function($m,$q){
			return $m->refSQL('xMarketingCampaign/Campaign')->count();
		})->sortable(true);

		$this->hasMany('xMarketingCampaign/Campaign','category_id');
		$this->addHook('beforeDelete',$this);
		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		if($this->ref('xMarketingCampaign/Campaign')->count()->getOne() > 0)
			throw $this->exception('Cannot Delete, First Delete it\'s Campaigns','Growl');
	}

	function forceDelete(){
		$this->ref('xMarketingCampaign/Campaign')->each(function($m){
			$m->forceDelete();
		});

		$this->delete();
	}

}