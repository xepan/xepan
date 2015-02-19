<?php

namespace xCRM;

class View_Communication extends \View{
	public $include_deep_communication=false;
	public $document;

	function init(){
		parent::init();
		$this->add('View_Info')->set($this->document['name']);
	}
}