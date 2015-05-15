<?php

namespace xShop;

class Model_Blog extends Model_Item{

	function init(){
		parent::init();
		
		$app = $this->add('xShop/Model_BlogApplication')->tryLoadAny();

		$this->addCondition('is_blog',true);
		$this->addCondition('application_id',$app->id);
	}
}