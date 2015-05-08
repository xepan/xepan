<?php

namespace xImageGallery;


class Plugins_epanDelete extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_before_delete',array($this,'Plugins_epanDelete'));
	}

	function Plugins_epanDelete($obj, $epan){		
		$models = array(
				'Model_Gallery'
			);

		foreach ($models as $m) {
			$this->add("xImageGallery\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}
	}
}
