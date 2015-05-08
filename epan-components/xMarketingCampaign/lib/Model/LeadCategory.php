<?php

namespace xMarketingCampaign;

class Model_LeadCategory extends \Model_Document {
	public $table ='xmarketingcampaign_lead_categories';
	public $status=array();
	public $root_document_name="xEnquiryNSubscription\LeadCategory";
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
		);

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->addField('name')->sortable(true);

		$this->addExpression('totalleads')->set(function($m,$q){
			return $m->refSQL('xMarketingCampaign/Lead')->count();
		})->sortable(true);

		$this->hasMany('xMarketingCampaign/Lead','leadcategory_id');
		$this->addHook('beforeDelete',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		if($this->ref('xMarketingCampaign/Lead')->count()->getOne() > 0)
			throw $this->exception('Category contains Leads','Growl');
	}

	function forceDelete(){
		$this->ref('xMarketingCampaign/Lead')->each(function($m){
			$m->forceDelete();
		});
		$this->delete();
	}
}