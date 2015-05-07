<?php

namespace xShop;


class Plugins_epanDeleted extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_before_delete',array($this,'Plugins_epanDeleted'));
	}

	function Plugins_epanDeleted($obj, $epan){

	}
}
