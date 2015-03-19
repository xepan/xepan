<?php
class page_xStore_page_owner_materialrequestsent extends page_xStore_page_owner_main {
	function init(){
		parent::init();

		$this->api->stickyGET('department_id');
		// $this->add('PageHelp',array('page'=>'materialrequestsent'));
		
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/draft','Draft'.$this->add('xStore/Model_MaterialRequestSent_Draft')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/submitted','Submitted'.$this->add('xStore/Model_MaterialRequestSent_Submitted')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/approved','Approved & Sent'.$this->add('xStore/Model_MaterialRequestSent_Approved')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/received','Received'.$this->add('xStore/Model_MaterialRequestSent_Received')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/assigned','Assigned'.$this->add('xStore/Model_MaterialRequestSent_Assigned')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/processing','Processing'.$this->add('xStore/Model_MaterialRequestSent_Processing')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/processed','Processed'.$this->add('xStore/Model_MaterialRequestSent_Processed')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/completed','Completed'.$this->add('xStore/Model_MaterialRequestSent_Completed')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/cancelled','Cancelled'.$this->add('xStore/Model_MaterialRequestSent_Cancelled')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/return','Return'.$this->add('xStore/Model_MaterialRequestSent_Return')->myUnRead());














	}
}