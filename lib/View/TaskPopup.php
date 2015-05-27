<?php

class TaskPopup extends \View {
	
	function init(){
		parent::init();
		$this->js(true)->univ()->setInterval( $this->js()->univ()->bgajaxec($this->api->url('owner/unreadtasks'))->_enclose() ,5000);
	}
}