<?php

namespace xAccount;


class Plugins_epanCreated extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_after_created',array($this,'Plugins_epanCreated'));
	}

	function Plugins_epanCreated($obj, $epan){

	}
}
