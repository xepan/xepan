<?php
class page_xDispatch_page_owner_dispatchrequest extends page_xDispatch_page_owner_main {
	function init(){
		parent::init();
		
		$this->api->stickyGET('department_id');

		$tabs=$this->add('Tabs');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_toreceive','To Receive');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_received','Received');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_partialcomplete','Partial Complete');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_complete','Complete');
	}

}