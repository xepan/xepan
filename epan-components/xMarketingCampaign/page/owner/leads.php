<?php

class page_xMarketingCampaign_page_owner_leads extends page_xMarketingCampaign_page_owner_main{
	
	function page_index(){
		$this->app->title=$this->api->current_department['name'] .': Leads';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> xMarketingCampaign Leads <small> Manage Your Leads </small>');
		// Add Badges


		$leads=$this->add('xMarketingCampaign/Model_Lead');
		
		$crud=$this->add('CRUD',array('grid_class'=>'xMarketingCampaign/Grid_Lead'));
		$crud->setModel($leads);
		$crud->add('xHR/Controller_Acl');
	}

	function page_category(){
		$lead_id = $this->api->stickyGET('xenquirynsubscription_subscription_id');

		$asso = $this->add('xEnquiryNSubscription\Model_SubscriptionCategoryAssociation');
		$asso->addCondition('subscriber_id',$lead_id);

		$crud = $this->add('CRUD');
		$crud->setModel($asso);
	}

}