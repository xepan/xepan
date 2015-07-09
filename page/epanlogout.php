<?php

class page_epanlogout extends Page{
	
	function page_index(){
		// parent::init();


		$url = $_GET['logout_url'];
		
		$this->api->destroySession();
		if(strpos($url, "http://") !== false){
			$this->js(true)->univ()->location($url);
		}else{
			$this->js(true)->univ()->redirect($this->api->url(null,array('subpage'=>$url)));
		}

	}
}