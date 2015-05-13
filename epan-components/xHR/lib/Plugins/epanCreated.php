<?php

namespace xHR;


class Plugins_epanCreated extends \componentBase\Plugin {

	function init(){
		parent::init();
		$this->addHook('epan_after_created',array($this,'Plugins_epanCreated'));
	}

	function Plugins_epanCreated($obj, $epan){
		$default_departments = array(
				array('name'=>'Company','is_production_department'=>0,'related_application_namespace'=>'','is_system'=>1,'jobcard_document'=>'Model_jobCard','production_level'=>null),
				array('name'=>'HR','is_production_department'=>0,'related_application_namespace'=>'xHR','is_system'=>1,'jobcard_document'=>'xProduction/Model_jobCard','production_level'=>null),
				array('name'=>'Marketing','is_production_department'=>0,'related_application_namespace'=>'xMarketingCampaign','is_system'=>1,'jobcard_document'=>'xProduction/Model_jobCard','production_level'=>null),
				array('name'=>'Sales','is_production_department'=>0,'related_application_namespace'=>'xShop','is_system'=>1,'jobcard_document'=>'xProduction/Model_jobCard','production_level'=>null),
				array('name'=>'Purchase','is_production_department'=>0,'related_application_namespace'=>'xStore','is_system'=>1,'jobcard_document'=>'xStore/Model_MaterialRequest','production_level'=>-2),
				array('name'=>'Accounts','is_production_department'=>0,'related_application_namespace'=>'xAccount','is_system'=>1,'jobcard_document'=>'xProduction/Model_JobCard','production_level'=>null),
				array('name'=>'CRM','is_production_department'=>0,'related_application_namespace'=>'xCRM','is_system'=>1,'jobcard_document'=>'xProduction/Model_JobCard','production_level'=>null),
				array('name'=>'Store','is_production_department'=>0,'related_application_namespace'=>'xStore','is_system'=>1,'jobcard_document'=>'xStore/Model_MaterialRequest','production_level'=>-1),
				array('name'=>'Dispatch And Delivery','is_production_department'=>0,'related_application_namespace'=>'xDispatch','is_system'=>1,'jobcard_document'=>'xDispatch/Model_DispatchRequest','production_level'=>100000),
			);

		$new_departments_with_ids =array();
		foreach ($default_departments as $d) {
			$new_dept = $this->add('xHR/Model_Department',array('bypass_validations'=>true))->set($d)->save();
			$new_departments_with_ids[$d['name']] = $new_dept->id;
		}

		$this->add('xHR/Model_Document')->loadDefaults($new_departments_with_ids);

		$company = $this->add('xHR/Model_Department')->loadCompany();

		// Create default Post
		$post=$this->add('xHR/Model_Post',array('bypass_validations'=>true));
		$post->addCondition('department_id',$company->id);

		$post['name']='Director';
		$post['can_create_team']=true;
		$post->save();

		// Create Default Employee and Associate it with default User
		$emp = $this->add('xHR/Model_Employee');
		$emp['post_id']= $post->id;
		$emp['user_id']= $this->add('Model_Users')->getDefaultSuperUser()->get('id');
		$emp['department_id']= $company->id;
		$emp['name']= 'Owner';
		$emp->save();

	}
}
