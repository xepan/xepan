<?php

namespace xMarketingCampaign;


class Plugins_epanDelete extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epanDeleted',array($this,'Plugins_epanDelete'));
	}

	function Plugins_epanDelete($obj, $epan){

	}
}
