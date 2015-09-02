<?php

class View_Notification extends View {
	public $update_seen_till=false;
	
	function render(){
		$this->js(true)
			->_load('pnotify.custom.min')
			->_css('pnotify.custom.min');
		$this->js(true)->_library('PNotify.desktop')->permission();
		$this->js(true)->_load('xepan.pnotify')->univ()->getNotification($this->api->url('/owner_notification'));
		parent::render();
	}
}