<?php

class page_xMarketingCampaign_page_owner_update extends page_componentBase_page_update {
		
	public $git_path="https://github.com/xepan/xMarketingCampaign"; // Put your components git path here

	function init(){
		parent::init();

		// 
		// Code To run before update
		
		$this->update($dynamic_model_update=true, $git_update=false);
		$this->add('View_Info')->set('Component Updated Successfully');

		$this->add('xMarketingCampaign/Controller_SocialPosters_Facebook');
		$this->add('xMarketingCampaign/Controller_SocialPosters_GoogleBlogger');
		$this->add('xMarketingCampaign/Controller_SocialPosters_Linkedin');

		$social_models=array(
			'xMarketingCampaign/Model_GoogleBloggerConfig',
			'xMarketingCampaign/Model_SocialConfig',
			'xMarketingCampaign/Model_SocialUsers',
			'xMarketingCampaign/Model_SocialPosting',
			'xMarketingCampaign/Model_Activity',
			
			);
		$this->updateModels($social_models);
		

		// Code to run after update
	}


}