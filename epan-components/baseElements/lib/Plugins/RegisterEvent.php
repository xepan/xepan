<?php

namespace baseElements;


class Plugins_RegisterEvent extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('register-event',array($this,'Plugins_RegisterEvent'));
	}

	function Plugins_RegisterEvent($obj, $events_obj){
		$events_obj->events[] = "new_user_registered";
	}
}
