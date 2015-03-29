<?php
class page_xAccount_page_owner_amtpaid extends page_xAccount_page_owner_main {
	
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Payment';

	}
}