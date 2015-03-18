<?php
class page_xDispatch_page_owner_dispatchrequest extends page_xDispatch_page_owner_main {
	function init(){
		parent::init();
		$tabs=$this->app->layout->add('Tabs');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_draft','Draft');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_submit','Submitted');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_approve','Approved/To Receive');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_received','Received');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_assigned','Assigned');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_processed','Processed');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_completed','Completed');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_cancelled','Cancel');
	}

}