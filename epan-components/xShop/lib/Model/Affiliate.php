<?php

namespace xShop;
class Model_Affiliate extends \Model_Document {
	var $table= "xshop_affiliate";
	public $status = array();
	public $actions = array(
				'can_see_activities'=>array(),
				'allow_del'=>array(),
				'allow_edit'=>array(),
				'allow_add'=>array()
				);
	public $root_document_name = 'xShop\Affiliate';

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xShop/Application','application_id');
		$f = $this->hasOne('xShop/AffiliateType','affiliatetype_id')->mandatory(true)->sortable(true);
		
		$f->icon = "fa fa-user~blue";
		$f = $this->addField('company_name')->caption('Company Name')->mandatory(true)->group('a~5~<i class="fa fa-info"></i> Basic Info')->sortable(true);
		$f->icon = "fa fa-circle~red";
		$f = $this->addField('name')->caption('Owner Name')->mandatory(true)->group('a~5~<i class="fa fa-info"></i> Basic Info')->sortable(true);
		$f->icon = "fa fa-circle~red";

		$this->add('filestore/Field_Image','logo_url_id');
		// $f = $this->addField('logo_url')->display(array('form'=>'ElImage'))->group('a~5');
		$f->icon = "glyphicon glyphicon-picture~blue";
		$f = $this->addField('is_active')->type('boolean')->defaultValue('true')->group('a~2')->sortable(true);
		$f->icon ="fa fa-exclamation~blue";
		$f = $this->addField('phone_no')->type('number')->group('c~3~<i class="fa fa-link"></i> Digital Contact')->sortable(true);
		$f->icon="fa fa-phone~blue";
		$f = $this->addField('mobile_no')->type('number')->group('c~3')->sortable(true);
		$f->icon="fa fa-mobile~blue";
		$f = $this->addField('email_id')->group('c~3')->sortable(true);
		$f->icon="fa fa-envelope~blue";
		$f = $this->addField('website_url')->group('c~3')->sortable(true);
		$f->icon="fa fa-globe~blue";
		$this->addField('office_address')->type('text')->mandatory(true)->group('b~12~<i class="fa fa-credit-card"></i> Address');
		$f = $this->addField('city')->group('b~3~Address')->sortable(true)->sortable(true);
		$this->addField('state')->group('b~3~Address')->sortable(true)->sortable(true);
		$this->addField('country')->group('b~3~Address')->sortable(true)->sortable(true);
		$this->addField('zip_code')->caption('Zip/postal code')->group('b~2')->sortable(true);
		
		$f = $this->addField('description')->type('text')->display(array('form'=>'RichText'));
		$f->icon = "fa fa-pencil~blue";
		
		// $this->addHook('beforeSave',$this);
		$this->hasMany('xShop/ItemAffiliateAssociation','affiliate_id');

		$this->add('Controller_Validator');
		$this->is(array(
						     // 'email_id|as|email|required|unique?email must be valid',
    						 'phone_no|to_trim',
    						 'mobile_no|to_trim'

		));

		//$this->add('dynamic_model/Controller_AutoCreator');

	}

	function beforeDelete(){
		$this->ref('xShop/ItemAffiliateAssociation')->deleteAll();
	}

	function updateEmail($email){
		if(!$this->loaded()) return false;
		
		$this['email_id'] = $this['email_id'].', '.$email;
		$this->save();
	}

	function deactivate(){
		if(!$this->loaded())
			return false;
		
		$this['is_active'] = false;
		$this->save();
		return true;
	}

	function email(){
		if(!$this->loaded())
			return false;
		return $this['email_id'];
	}

	function mobileno(){
		if(!$this->loaded())
			return false;
		return $this['mobile_no'];	
	}
}