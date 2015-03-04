<?php
class page_xShop_page_owner_materialrequest extends page_xShop_page_owner_main {
	function init(){
		parent::init();
		$tabs=$this->app->layout->add('Tabs');
		$tabs->addTabURL('xStore_page_owner_materialrequest_submit','Submitted');
		$tabs->addTabURL('xStore_page_owner_materialrequest_received','Received');
		$tabs->addTabURL('xStore_page_owner_materialrequest_processing','Processing');
		$tabs->addTabURL('xStore_page_owner_materialrequest_processed','Processed');
		$tabs->addTabURL('xStore_page_owner_materialrequest_approved','Approved');
		$tabs->addTabURL('xStore_page_owner_materialrequest_complete','Completed');
		$tabs->addTabURL('xStore_page_owner_materialrequest_cancel','Cancel');
		$tabs->addTabURL('xStore_page_owner_materialrequest_return','Return');
	}
}
