<?php

namespace xMarketingCampaign;

class Model_SocialPostCategory extends \Model_Table {
	public $table="xmarketingcampaign_socialpost_categories";

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$f=$this->addField('name')->mandatory(true)->group('a1~6~Social Post Category')->sortable(true)->display(array('grid'=>'shorttext'));
		$f->icon='fa fa-adn~red';

		$this->addExpression('posts')->set(function($m,$q){
			return $m->refSQL('xMarketingCampaign/SocialPost')->count();
		});

		$this->hasMany('xMarketingCampaign/SocialPost','category_id');

		$this->addHook('beforeDelete',$this);

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		if($this->ref('xMarketingCampaign/SocialPost')->count()->getOne() > 0)
			throw $this->exception('Cannot Delete, First Delete it\'s Social Post ','Growl');
	}

	function forceDelete(){
		$this->ref('xMarketingCampaign/SocialPost')->each(function($m){
			$m->delete();
		});
	}

}