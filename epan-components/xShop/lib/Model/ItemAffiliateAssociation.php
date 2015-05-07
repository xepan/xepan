<?php

namespace xShop;

class Model_ItemAffiliateAssociation extends \SQL_Model{
	public $table='xshop_item_affiliate_ass';
	
	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xShop/Item','item_id');
		$this->hasOne('xShop/AffiliateType','affiliatetype_id');
		$this->hasOne('xShop/Affiliate','affiliate_id');

		$this->addField('is_active')->type('boolean')->defaultValue(false)->system(true);
				
		//$this->add('dynamic_model/Controller_AutoCreator');
	}
}