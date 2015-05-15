<?php

namespace xShop;

class Model_AffiliateType extends \Model_Document {
	var $table= "xshop_affiliatetype";
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

		//Mutiple Epan website
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->hasOne('xShop/Application','application_id');

		$this->addField('name')->sortable(true);
		$this->hasMany('xShop/Affiliate','affiliatetype_id');
		$this->hasMany('xShop/ItemAffiliateAssociation','affiliatetype_id');
		$this->addHook('beforeDelete',$this);	
		//$this->add('dynamic_model/Controller_AutoCreator');
	
	}

	function beforeDelete(){
		if($this->ref('xShop/Affiliate')->count()->getOne() > 0){
			throw $this->exception("Cannot Delete, First Delete it's Affiliate",'Growl');
		}	
	}


	function forceDelete(){
		$this->ref('xShop/Affiliate')->each(function($affiliate){
			$affiliate->forceDelete();
		});

		$this->ref('xShop/ItemAffiliateAssociation')->deleteAll();

		$this->delete();
	}

}