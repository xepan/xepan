<?php

namespace xShop;

class Model_ImageLibraryCategory extends \Model_Table {
	var $table= "xshop_image_library_category";
	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$f = $this->addField('name')->caption('Category Name');
		$this->hasMany('xShop/MemberImages','category_id');
		//$this->add('dynamic_model/Controller_AutoCreator');		
	}
}