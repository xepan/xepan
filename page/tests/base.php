<?php

class page_tests_base extends Page_Tester {
	
	function init(){
		ini_set('memory_limit', '2048M');
		set_time_limit(0);		
		parent::init();
	}
}