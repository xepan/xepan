<?php
class page_xStore_page_owner_materialrequestsent extends page_xStore_page_owner_main {
	function init(){
		parent::init();

		$this->api->stickyGET('department_id');
		// $this->add('PageHelp',array('page'=>'materialrequestsent'));
		
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent_draft','Draft');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent_submitted','Submitted');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent_approved','Approved & Sent');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent_received','Recieved');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent_assigned','Assigned');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent_processing','Processing');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent_processed','Processed');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent_completed','Completed');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent_cancelled','Cancelled');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent_return','Return');



	}
}