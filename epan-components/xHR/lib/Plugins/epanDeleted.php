<?php

namespace xHR;


class Plugins_epanDeleted extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_before_delete',array($this,'Plugins_epanDeleted'));
	}

	function Plugins_epanDeleted($obj, $epan){
		$models=array('Model_Department','Model_Employee');
		foreach ($models as $m) {
			$this->add("xHR\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}

	}
}
