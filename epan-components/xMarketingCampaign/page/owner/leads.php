<?php

class page_xMarketingCampaign_page_owner_leads extends page_xMarketingCampaign_page_owner_main{
	
	function page_index(){
			$this->app->title=$this->api->current_department['name'] .': Leads';
		// Add Badges

		// filter line if filter is there

		$leads=$this->app->layout->add('xMarketingCampaign/Model_Lead');
		$leads->addCondition('source','DataFeed');
		$leads->addCondition('source_id','0');

		$crud=$this->add('CRUD');
		$crud->setModel($leads);

		$crud->add('xHR/Controller_Acl');

	}
}