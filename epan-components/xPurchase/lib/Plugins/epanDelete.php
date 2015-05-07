<?php

namespace xPurchase;


class Plugins_epanDelete extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epanDeleted',array($this,'Plugins_epanDelete'));
	}

	function Plugins_epanDelete($obj, $epan){
		$models=array(
				'Model_Supplier',
				'Model_PurchaseOrder',
				'Model_PurchaseInvoice',
				);

		foreach ($models as $m) {
			$this->add("xPurchase\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}
	}
}
