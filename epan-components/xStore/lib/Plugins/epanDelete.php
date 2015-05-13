<?php

namespace xStore;


class Plugins_epanDelete extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_before_delete',array($this,'Plugins_epanDelete'));
		// $this->addHook('epanDeleted',array($this,'Plugins_epanDelete'));
	}

	function Plugins_epanDelete($obj, $epan){		
		$models=array(
				'Model_Warehouse',
				'Model_StockMovement',
				'Model_MaterialRequest',
				'Model_Stock',
				);

		foreach ($models as $m) {
			$this->add("xStore\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}
	}
}
