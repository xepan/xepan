<?php

namespace xCRM;


class Plugins_epanDelete extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epanDeleted',array($this,'Plugins_epanDelete'));
	}

	function Plugins_epanDelete($obj, $epan){
		$models=array('Model_Activity',
					'Model_Email',
					'Model_SMS',
					'Model_Ticket'
				);

		foreach ($models as $m) {
			$this->add("xCRM\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}
	}
}
