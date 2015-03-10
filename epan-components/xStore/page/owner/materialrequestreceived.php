<?php
class page_xStore_page_owner_materialrequestreceived extends page_xStore_page_owner_main {
	function init(){
		parent::init();
		$this->api->stickyGET('department_id');

		$tabs=$this->add('Tabs');
		//$tabs->addTabURL('xStore_page_owner_materialrequestreceived_draft','Draft');
		// $tabs->addTabURL('xStore_page_owner_materialrequestreceived_submit','Submitted');
		//$tabs->addTabURL('xStore_page_owner_materialrequestreceived_assigned','Assigned');
		$tabs->addTabURL('xStore_page_owner_materialrequestreceived_toreceive','To Receive');
		$tabs->addTabURL('xStore_page_owner_materialrequestreceived_received','Received');
		$tabs->addTabURL('xStore_page_owner_materialrequestreceived_processing','Processing');
		$tabs->addTabURL('xStore_page_owner_materialrequestreceived_processed','Processed');
		$tabs->addTabURL('xStore_page_owner_materialrequestreceived_complete','Completed');
		$tabs->addTabURL('xStore_page_owner_materialrequestreceived_cancel','Cancel');
		$tabs->addTabURL('xStore_page_owner_materialrequestreceived_return','Return');



	}
}