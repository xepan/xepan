<?php

class page_xPurchase_page_owner_materialrequest extends page_xPurchase_page_owner_main {
	
	function init(){
		parent::init();

		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small> Manage Your Material Request</small>');


			$tabs=$this->app->layout->add('Tabs');
			$tabs->addTabURL('xPurchase_page_owner_purchasematerialrequest_draft','Draft');
			$tabs->addTabURL('xPurchase_page_owner_purchasematerialrequest_submitted','Submitted');
			$tabs->addTabURL('xPurchase_page_owner_purchasematerialrequest_processed','Processed');
			$tabs->addTabURL('xPurchase_page_owner_purchasematerialrequest_completed','Completed');
			$tabs->addTabURL('xPurchase_page_owner_purchasematerialrequest_rejected','Rejected');
	}

}
