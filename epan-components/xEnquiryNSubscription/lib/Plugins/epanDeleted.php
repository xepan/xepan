<?php

namespace xEnquiryNSubscription;


class Plugins_epanDeleted extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_before_delete',array($this,'Plugins_epanDeleted'));
	}

	function Plugins_epanDeleted($obj, $epan){		
		$models=array('Model_Config','Model_EmailJobs','Model_MassEmailConfiguration','Model_NewsLetter','Model_NewsLetterCategory','Model_Subscription','Model_SubscriptionCategories');
		foreach ($models as $m) {
			$this->add("xEnquiryNSubscription\\".$m)->each(function($model){
				$model->forceDelete();
			});
		}
	}
}
