<?php

namespace xShop;

class Model_BlogCategory extends Model_Category {
	function init(){
		parent::init();

		$blog_app = $this->add('xShop/Model_BlogApplication')->tryLoadAny();

		$this->addCondition('application_id',$blog_app->id);
	}

	

}