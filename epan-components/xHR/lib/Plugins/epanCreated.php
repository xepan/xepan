<?php

namespace xHR;


class Plugins_epanCreated extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_after_created',array($this,'Plugins_epanCreated'));
	}

	function Plugins_epanCreated($obj, $epan){
		$default_departments = array(
				array('name'=>'Company','is_production_department'=>0,'related_application_namespace'=>'','is_system'=>1,'jobcard_document'=>'jobCard','production_level'=>null),
				array('name'=>'HR','is_production_department'=>0,'related_application_namespace'=>'xHR','is_system'=>1,'jobcard_document'=>'jobCard','production_level'=>null),
				array('name'=>'Marketing','is_production_department'=>0,'related_application_namespace'=>'xMarketingCampaign','is_system'=>1,'jobcard_document'=>'jobCard','production_level'=>null),
				array('name'=>'Sales','is_production_department'=>0,'related_application_namespace'=>'xShop','is_system'=>1,'jobcard_document'=>'jobCard','production_level'=>null),
				array('name'=>'Purchase','is_production_department'=>1,'related_application_namespace'=>'xStore','is_system'=>1,'jobcard_document'=>'MaterialRequest','production_level'=>-2),
				array('name'=>'Accounts','is_production_department'=>0,'related_application_namespace'=>'xAccount','is_system'=>1,'jobcard_document'=>'JobCard','production_level'=>null),
				array('name'=>'CRM','is_production_department'=>0,'related_application_namespace'=>'xCRM','is_system'=>1,'jobcard_document'=>'JobCard','production_level'=>null),
				array('name'=>'Store','is_production_department'=>1,'related_application_namespace'=>'xStore','is_system'=>1,'jobcard_document'=>'MaterialRequest','production_level'=>-1),
				array('name'=>'Dispatch And Delivery','is_production_department'=>1,'related_application_namespace'=>'xDispatch','is_system'=>1,'jobcard_document'=>'DispatchRequest','production_level'=>100000),
			);

		foreach ($default_departments as $d) {
			$this->add('xHR/Model_Department',array('bypass_validations'=>true))->set($d)->save();
		}

		$this->add('xHR/Model_Document')->loadDefaults();
	}
}
