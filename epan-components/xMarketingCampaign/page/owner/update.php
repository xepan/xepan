<?php

class page_xMarketingCampaign_page_owner_update extends page_componentBase_page_update {
		
	public $git_path="https://github.com/xepan/xMarketingCampaign"; // Put your components git path here

	function init(){
		parent::init();

		// 
		// Code To run before update
		

		$files=array(
				'Base/Social.php',
				'Facebook.php',
				'GoogleBlogger.php',
				'Linkedin.php',
			);
		foreach ($files as $file) {
			try{
				require_once('epan-components/xMarketingCampaign/lib/Controller/SocialPosters/'.$file);
			}catch(\Exception $e){
				throw $e;
			}
		}

		$social_models=array(
			'xMarketingCampaign/Model_GoogleBloggerConfig',
			'xMarketingCampaign/Model_SocialConfig',
			'xMarketingCampaign/Model_SocialUsers',
			'xMarketingCampaign/Model_SocialPosting',
			'xMarketingCampaign/Model_Activity',
			
			);
		
		$this->updateModels($social_models);

		$this->update($dynamic_model_update=true, $git_update=false);
		$this->add('View_Info')->set('Component Updated Successfully');
		

		// Code to run after update
	}


}