<?php

namespace xShop;
class Model_Application extends \Model_Document{
	
	var $table="xshop_application";
	public $status=array();
	public $document_name=null;
	public $root_document_name="xShop\Application";
	
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$f=$this->addField('name')->mandatory(true)->group('a~12')->sortable(true);
		$f->icon = 'fa fa-folder~red';
		
		$this->addField('type')->enum(array('Shop','Blog'));

		$this->hasMany('xShop/Category','application_id');
		$this->hasMany('xShop/Item','application_id');
		$this->hasMany('xShop/CustomFields','application_id');
		$this->hasMany('xShop/Specification','application_id');
		$this->hasMany('xShop/Configuration','application_id');
		$this->hasMany('xShop/ItemOffer','application_id');
		$this->addHook('beforeDelete',$this);

		
		// $this->add('dynamic_model/Controller_AutoCreator'); 
	}

	function beforeDelete($m){
		$cats = $m->ref('xShop/Category')->count()->getOne();
		$items = $m->ref('xShop/Item')->count()->getOne();
		$cfs = $m->ref('xShop/CustomFields')->count()->getOne();
		$specs = $m->ref('xShop/Specification')->count()->getOne();
		$config = $m->ref('xShop/Configuration')->count()->getOne();
		$offers = $m->ref('xShop/ItemOffer')->count()->getOne();

		if($cats or $items or $cfs or $specs or $config or $offers){
			throw $this->exception("Shop/Blog (".$m['name'].") cannot deleted, first delete its category",'Growl');
		}	

	}

	function forceDelete(){
		$this->ref('xShop/Category')->each(function($cat){
			$cat->forceDelete();
		});

		$this->ref('xShop/Item')->each(function($item){
			$item->forceDelete();
		});

		$this->ref('xShop/CustomFields')->each(function($cf){
			$cf->forceDelete();
		});

		$this->ref('xShop/Specification')->each(function($spe){
			$spe->forceDelete();
		});

		$this->ref('xShop/Configuration')->each(function($config){
			$config->forceDelete();
		});

		$this->ref('xShop/ItemOffer')->each(function($offer){
			$offer->forceDelete();
		});
		
		$this->delete();
	}


}		