<?php

namespace xDispatch;


class Plugins_epanDelete extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_before_delete',array($this,'Plugins_epanDelete'));
	}

	function Plugins_epanDelete($obj, $epan){
		$models=array(
				'Model_DeliveryNote',
				'Model_DeliveryNote',
			);

		foreach ($models as $m) {
			$this->add("xDispatch\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}
	}
}
