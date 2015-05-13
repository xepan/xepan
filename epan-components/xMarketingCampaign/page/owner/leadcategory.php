<?php

class page_xMarketingCampaign_page_owner_leadcategory extends page_xMarketingCampaign_page_owner_main{
	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('xMarketingCampaign/LeadCategory');

		$crud->grid->removeColumn('item_name');

	}
}