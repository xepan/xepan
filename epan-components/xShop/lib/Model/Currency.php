<?php

namespace xShop;
class Model_Currency extends \Model_Table {
	var $table= "xshop_currency";
	public $root_document_name = 'xShop\Currency';

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->addField('name')->mandatory(true);
		$this->addField('Value')->mandatory(true)->hint('INR ');
		$this->addField('is_default')->type('boolean');

		$this->hasMany('xShop/Quotation','currency_id');
		$this->hasMany('xShop/Invoice','currency_id');
		$this->hasMany('xShop/Order','currency_id');

		$this->addHook('beforeSave',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}


	function beforeSave(){		
		$old_currency = $this->add('xShop/Model_Currency');
		$old_currency->addCondition('id','<>',$this->id);
		$old_currency->tryLoadAny();

		if($old_currency['is_default'] == $this['is_default'])
			throw $this->error('Default Currency is Already Defined','Growl');

	}

	function defaultCurrency(){
		return $this->addCondition('is_default',true)->tryLoadAny();
	}

}