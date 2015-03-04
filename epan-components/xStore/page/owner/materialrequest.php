<?php
class page_xStore_page_owner_materialrequest extends page_xStore_page_owner_main {
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small> Manage Your Material Request</small>');

		$tabs=$this->app->layout->add('Tabs');
		$tabs->addTabURL('xStore_page_owner_materialrequest_draft','Draft');
		$tabs->addTabURL('xStore_page_owner_materialrequest_submit','Submitted');
		// $tabs->addTabURL('xStore_page_owner_materialrequest_received','Received');
		$tabs->addTabURL('xStore_page_owner_materialrequest_assigned','Assigned');
		$tabs->addTabURL('xStore_page_owner_materialrequest_processing','Processing');
		$tabs->addTabURL('xStore_page_owner_materialrequest_processed','Processed');
		// $tabs->addTabURL('xStore_page_owner_materialrequest_approved','Approved');
		$tabs->addTabURL('xStore_page_owner_materialrequest_forwarded','Forwarded');
		$tabs->addTabURL('xStore_page_owner_materialrequest_complete','Completed');
		$tabs->addTabURL('xStore_page_owner_materialrequest_cancel','Cancel');
		$tabs->addTabURL('xStore_page_owner_materialrequest_return','Return');
	}
}
