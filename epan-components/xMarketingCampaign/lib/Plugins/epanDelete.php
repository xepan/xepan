<?php

namespace xMarketingCampaign;


class Plugins_epanDelete extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_before_delete',array($this,'Plugins_epanDelete'));
	}

	function Plugins_epanDelete($obj, $epan){			
		$models = array(
					'Model_LeadCategory',
					'Model_SocialPostCategory',
					'Model_DataGrabber',
					'Model_CampaignCategory',
				);

		foreach ($models as $m) {
			$this->add("xMarketingCampaign\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}
	}
}
