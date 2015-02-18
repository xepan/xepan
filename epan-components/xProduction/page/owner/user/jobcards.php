<?php

class page_xProduction_page_owner_user_jobcards extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();

		$tabs=$this->app->layout->add('Tabs');
		$tabs->addTabURL('xProduction_page_owner_user_assigned','Assigned To Me');
		$tabs->addTabURL('xProduction_page_owner_user_processing','Processing');
		$tabs->addTabURL('xProduction_page_owner_user_processed','Processed');

	}
}