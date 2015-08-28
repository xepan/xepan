<?php

namespace xShop;

class Model_MemberImages extends \Model_Table {
	var $table= "xshop_member_images";
	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		$this->hasOne('xShop/ImageLibraryCategory','category_id');
				
		$this->hasOne('xShop/MemberDetails','member_id');

		$f = $this->add('filestore/Field_Image','image_id')->mandatory(true);
		$f->icon ="glyphicon glyphicon-picture~blue";
		$f = $this->addField('alt_text')->group('a~11~bl');
		$f->icon ="glyphicon glyphicon-pencil~blue";
		$f = $this->addField('title')->group('a~11~bl');
		$f->icon ="glyphicon glyphicon-pencil~blue";

		// $this->add('dynamic_model/Controller_AutoCreator');		
	}
}