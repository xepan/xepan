<?php
class page_xShop_page_owner_main extends page_componentBase_page_owner_main {
	function init(){
		parent::init();

		$this->api->addMethod('xshop_application_id',function($page){
			return $page->api->memorize('xshop_application_id',$page->api->recall('xshop_application_id',$page->add('xShop/Model_Application')->tryLoadAny()->get('id')));
		});
		$this->api->xshop_application_id();

	}


	function page_config(){
		$this->add('H1')->set('Default Config Page');
	}
}