<?php

namespace xMarketingCampaign;

class Model_Lead extends \Model_Document{
	public $table="xmarketingcampaign_leads";
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


		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->addField('lead_type')->enum(array('Sales'))->group('a~2~Basic Information');
		$this->addField('name')->sortable(true)->group('a~3');
		$this->addField('organization_name')->sortable(true)->group('a~4');
		$this->addField('website')->sortable(true)->group('a~3');
		// $this->addField('status');
		$this->addField('source')->sortable(true);
		$this->addField('source_id')->sortable(true);
		$this->addField('phone')->sortable(true)->group('b~3~Contact Information');
		$this->addField('mobile_no')->sortable(true)->group('b~3');
		$this->addField('email_id')->sortable(true)->group('b~3');
		$this->addField('fax')->group('b~3');

		$this->hasMany('xShop/Model_Oppertunity','lead_id');
		$this->hasMany('xShop/Model_Quotation','lead_id');

		$this->add('Controller_Validator');
		$this->is(array(
			'name|to_trim|to_alpha|len|>=3?Length must be more then 30 chars',
			'email_id|email|unique?Email not perfact or already used'
			)
		);

		//$this->add('dynamic_model/Controller_AutoCreator');
	}
}