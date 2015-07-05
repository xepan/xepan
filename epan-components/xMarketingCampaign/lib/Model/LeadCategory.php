<?php

namespace xMarketingCampaign;

class Model_LeadCategory extends \xEnquiryNSubscription\Model_SubscriptionCategories {
	// public $table ='xmarketingcampaign_lead_categories';
	public $status=array();
	public $root_document_name="xMarketingCampaign\LeadCategory";
	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
			'can_see_activities'=>false,
			'can_manage_attachments'=>false,
		);

	function init(){
		parent::init();

		// $this->hasOne('Epan','epan_id');
		// $this->addCondition('epan_id',$this->api->current_website->id);
		// $this->addField('name')->sortable(true);

		$this->addExpression('totalleads')->set(function($m,$q){
			// $asso = $m->add('xEnquiryNSubscription/Model_SubscriptionCategoryAssociation')->addCondition('category_id',$m->id);
			return $m->refSQL('xEnquiryNSubscription/SubscriptionCategoryAssociation')->count();
		})->sortable(true);

		// $this->hasMany('xMarketingCampaign/Lead','leadcategory_id');
		$this->addHook('beforeDelete',array($this,"leadCategoryBeforeDelete"));
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function leadCategoryBeforeDelete(){
		if($this->ref('xEnquiryNSubscription/SubscriptionCategoryAssociation')->count()->getOne() > 0)
			throw $this->exception('Category contains Leads','Growl');
				
	}

	
}