<?php
namespace xEnquiryNSubscription;


class Model_Subscription extends \Model_Document {
	var $table= "xEnquiryNSubscription_Subscription";
	public $status=array();
	public $root_document_name="xEnquiryNSubscription\Subscription";

	public $actions=array(
			'can_view'=>array(),
			'allow_edit'=>array(),
			'allow_add'=>array(),
			'allow_del'=>array(),
		);
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id')->system(true);
		$this->addCondition('epan_id',$this->api->current_website->id);
		// $this->hasOne('xEnquiryNSubscription/SubscriptionCategories','category_id');
		$this->addField('lead_type')->group('a~2~Basic Information')->defaultValue('sales');
		$this->addField('name')->sortable(true)->group('a~3');
		$this->addField('organization_name')->sortable(true)->group('a~4');
		$this->addField('website')->sortable(true)->group('a~3');
		$f=$this->addField('email')->mandatory(true)->sortable(true)->group('b~3~Contact Information');
		$f->icon='fa fa-envelope~blue';
		$this->addField('phone')->sortable(true)->group('b~3');
		$this->addField('mobile_no')->sortable(true)->group('b~3');
		$this->addField('fax')->group('b~3');

		$f=$this->addField('is_ok')->type('boolean')->defaultValue(1)->sortable(true)->group('c~6~Other Information');
		$f->icon='fa fa-exclamation~blue';
		
		$f=$this->addField('ip')->caption('IP')->group('c~6');
		$f->icon = 'fa fa-desktop~blue';
		// $this->addField('send_news_letters')->type('boolean')->defaultValue(true);


		$this->addField('from_app')->system(true)->defaultValue('xEnquiryNSubscription')->sortable(true)->group('c~3');
		$this->addField('from_id')->type('int')->system(true)->group('c~3');


		$this->hasMany('xShop/Model_Oppertunity','lead_id');
		$this->hasMany('xShop/Model_Quotation','lead_id');
		$this->hasMany('xEnquiryNSubscription/SubscriptionCategoryAssociation','subscriber_id');

		$this->add('Controller_Validator');
		$this->is(array(
			'name|to_trim|to_alpha|len|>=3?Length must be more then 30 chars',
			'email_id|email|unique?Email not perfact or already used'
			)
		);

		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);

	// $this->add('dynamic_model/Controller_AutoCreator');

	}

	function beforeSave(){
		if(!$this['ip']){
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			    $ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
			    $ip = $_SERVER['REMOTE_ADDR'];
			}
			
			$this['ip'] = $ip;
		}

	}
	function beforeDelete(){
		$this->ref('xEnquiryNSubscription/SubscriptionCategoryAssociation')->deleteAll();
	}
}