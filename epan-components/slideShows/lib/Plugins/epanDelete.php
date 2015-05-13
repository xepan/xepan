<?php

namespace slideShows;


class Plugins_epanDelete extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_before_delete',array($this,'Plugins_epanDelete'));
	}

	function Plugins_epanDelete($obj, $epan){
		
		$models = array(
				'Model_AwesomeGallery',
				'Model_ThumbnailSliderGallery',
				'Model_TransformGallery',
				'Model_WaterWheelGallery',
				);

		foreach ($models as $m) {
			$this->add("slideShows\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}
	}
}
