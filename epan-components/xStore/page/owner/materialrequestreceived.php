<?php
class page_xStore_page_owner_materialrequestreceived extends page_xStore_page_owner_main {
	function init(){
		parent::init();
		$this->api->stickyGET('department_id');

		$tabs=$this->add('Tabs');
		//$tabs->addTabURL('xStore_page_owner_materialrequestreceived_draft','Draft');
		// $tabs->addTabURL('xStore_page_owner_materialrequestreceived_submit','Submitted');
		//$tabs->addTabURL('xStore_page_owner_materialrequestreceived_assigned','Assigned');


		$tabs->addTabURL('xStore/page/owner/materialrequestreceived/toreceive','To Receive'.$this->add('xStore/Model_MaterialRequestReceived_ToReceive')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestreceived/received','Received'.$this->add('xStore/Model_MaterialRequestReceived_Received')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestreceived/assigned','Assigned'.$this->add('xStore/Model_MaterialRequestReceived_Assigned')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestreceived/processing','Processing'.$this->add('xStore/Model_MaterialRequestReceived_Processing')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestreceived/processed','Processed'.$this->add('xStore/Model_MaterialRequestReceived_Processed')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestreceived/completed','Completed'.$this->add('xStore/Model_MaterialRequestReceived_Completed')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestreceived/cancelled','Cancelled'.$this->add('xStore/Model_MaterialRequestReceived_Cancelled')->myUnRead());
		$tabs->addTabURL('xStore/page/owner/materialrequestreceived/return','Return'.$this->add('xStore/Model_MaterialRequestReceived_Return')->myUnRead());



	}
}
