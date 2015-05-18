<?php

class page_xMarketingCampaign_page_owner_leadcategory extends page_xMarketingCampaign_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->add('CRUD',array('grid_class'=>'xMarketingCampaign/Grid_LeadCategory'));
		$crud->setModel('xMarketingCampaign/LeadCategory');

	}
}