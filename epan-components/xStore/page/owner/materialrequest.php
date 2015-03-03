<?php
class page_xStore_page_owner_materialrequest extends page_xStore_page_owner_main {
	function init(){
		parent::init();
		$tabs=$this->app->layout->add('Tabs');
		$tabs->addTabURL('xStore_page_owner_materialrequest_forwardedtome','Forwarded to Me');
		$tabs->addTabURL('xStore_page_owner_materialrequest_received','Received');
		$tabs->addTabURL('xStore_page_owner_materialrequest_assigned','Assigned');
		$tabs->addTabURL('xStore_page_owner_materialrequest_processing','Processing');
		$tabs->addTabURL('xStore_page_owner_materialrequest_processed','Processed');
		$tabs->addTabURL('xStore_page_owner_materialrequest_approved','Approved');
		$tabs->addTabURL('xStore_page_owner_materialrequest_forwardedtonext','Forwarded to Next');
		$tabs->addTabURL('xStore_page_owner_materialrequest_complete','Completed');
	}
}
