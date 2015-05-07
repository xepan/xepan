<?php

namespace xShop;

class Model_ItemReview extends \SQL_Model{
	public $table = 'xshop_item_reviews';
	
	function init(){
		parent::init();
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->hasOne('xShop/Item','item_id');
		$this->addField('rating')->type('number');
		$this->addField('review')->type('text');

		//$this->add('dynamic_model/Controller_AutoCreator');
	}
}