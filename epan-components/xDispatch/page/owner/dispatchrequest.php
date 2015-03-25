<?php
class page_xDispatch_page_owner_dispatchrequest extends page_xDispatch_page_owner_main {
	function init(){
		parent::init();
		
		$this->api->stickyGET('department_id');

		$tabs=$this->add('Tabs');
		//Dispatch Request
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_toreceive','Dispatch Request/ To Receive');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_received','Dispatch Request/ Received');
		
		//deliveryNote Start
		$tabs->addTabURL('xDispatch_page_owner_deliverynote_submitted','Submitted');
		$tabs->addTabURL('xDispatch_page_owner_deliverynote_approved','Approved');
		$tabs->addTabURL('xDispatch_page_owner_deliverynote_assigned','Assigned');
		$tabs->addTabURL('xDispatch_page_owner_deliverynote_processed','Processed');
		$tabs->addTabURL('xDispatch_page_owner_deliverynote_processing','Processing');
		$tabs->addTabURL('xDispatch_page_owner_deliverynote_completed','Completed');
		$tabs->addTabURL('xDispatch_page_owner_deliverynote_cancelled','Cancel');
	}

}