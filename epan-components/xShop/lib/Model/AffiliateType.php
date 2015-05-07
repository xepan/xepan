<?php

namespace xShop;

class Model_AffiliateType extends \Model_Table {
	var $table= "xshop_affiliatetype";
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