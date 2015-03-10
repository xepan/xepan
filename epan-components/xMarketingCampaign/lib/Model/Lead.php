<?php

namespace xMarketingCampaign;

class Model_Lead extends \Model_Document{
	public $table="xmarketingcampaign_leads";
	public $status=array();
	public $root_document_name="xMarketingCampaign\Lead";

	public $actions=array(
			'can_view'=>array('caption'=>'Whose created Leads this post can see'),
			'allow_edit'=>array('caption'=>'Whose created Leads this post can edit'),
			'allow_add'=>array('caption'=>'Can this post create new Leads'),
			'allow_del'=>array('caption'=>'Whose Created Leads this post can delete'),
		);
	
	function init(){
		parent::init();


		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->addField('name');
		$this->addField('organization_name');
		$this->addField('email_id');
		// $this->addField('status');
		$this->addField('source');
		$this->addField('source_id');
		$this->addField('phone');
		$this->addField('mobile_no');
		$this->addField('fax');
		$this->addField('website');
		$this->addField('lead_type')->enum(array('Sales'));

		$this->hasMany('xShop/Model_Oppertunity','lead_id');
		$this->hasMany('xShop/Model_Quotation','lead_id');

		$this->add('Controller_Validator');
		$this->is(array(
			'name|to_trim|to_alpha|len|>3?Length must be more then 30 chars',
			'email_id|email|unique?Email not perfact or already used'
			)
		);

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}