<?php

class page_baseElements_page_owner_main extends page_componentBase_page_owner_main {
	function init(){
		parent::init();
		$this->add('H1')->set('Component Owner Main Page');
	}


	function page_config(){
		$this->add('H1')->set('Default Config Page');
	}
}