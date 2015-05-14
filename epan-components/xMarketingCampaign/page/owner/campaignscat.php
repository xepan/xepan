<?php

class page_xMarketingCampaign_page_owner_campaignscat extends page_xMarketingCampaign_page_owner_main{

	function init(){
		parent::init();
		$this->app->title=$this->api->current_department['name'] .': Campaigns Category';
		$crud = $this->add('CRUD',array('grid_class'=>'xMarketingCampaign/Grid_CampaignCategory'));
		$model = $this->add('xMarketingCampaign/Model_CampaignCategory');
		$crud->setModel($model);
	}
}		