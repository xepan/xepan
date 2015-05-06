<?php

namespace xShop;


class Plugins_epanDeleted extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_before_delete',array($this,'Plugins_epanDeleted'));
	}

	function Plugins_epanDeleted($obj, $epan){
		$models=array('Model_Opportunity','Model_Customer','Model_Application');
		foreach ($models as $m) {
			$this->add("xShop\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}

	}
}
