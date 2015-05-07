<?php

namespace xProduction;


class Plugins_epanDelete extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epanDeleted',array($this,'Plugins_epanDelete'));
	}

	function Plugins_epanDelete($obj, $epan){
		$models=array('Model_JobCard','Model_OutSourceParty','Model_Task','Model_Team');

		foreach ($models as $m) {
			$this->add("xProduction\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}
	}
}
