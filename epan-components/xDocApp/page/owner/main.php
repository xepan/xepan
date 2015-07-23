<?php

class page_xDocApp_page_owner_main extends page_componentBase_page_owner_main {
	function initMainPage(){
		$this->add('H1')->set('xEpan Document');
	}


	function page_config(){
		$this->add('H1')->set('Default Config Page');
	}
}