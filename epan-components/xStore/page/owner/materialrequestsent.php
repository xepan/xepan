<?php
class page_xStore_page_owner_materialrequestsent extends page_xStore_page_owner_main {
	function init(){
		parent::init();

		$this->api->stickyGET('department_id');
		// $this->add('PageHelp',array('page'=>'materialrequestsent'));
		
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/draft','Draft'.$this->add('xStore/Model_MaterialRequestSent_Draft')->addCondition('from_department_id',$_GET['department_id'])->myCounts(true,false));
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/submitted','Submitted'.$this->add('xStore/Model_MaterialRequestSent_Submitted')->addCondition('from_department_id',$_GET['department_id'])->myCounts(true,false));
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/approved','Approved & Sent'.$this->add('xStore/Model_MaterialRequestSent_Approved')->addCondition('from_department_id',$_GET['department_id'])->myCounts(true,false));
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/received','Received'.$this->add('xStore/Model_MaterialRequestSent_Received')->addCondition('from_department_id',$_GET['department_id'])->myCounts(true,false));
		// $tabs->addTabURL('xStore/page/owner/materialrequestsent/assigned','Assigned'.$this->add('xStore/Model_MaterialRequestSent_Assigned')->addCondition('from_department_id',$_GET['department_id'])->myCounts(true,false));
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/processing','Processing'.$this->add('xStore/Model_MaterialRequestSent_Processing')->addCondition('from_department_id',$_GET['department_id'])->myCounts(true,false));
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/processed','Processed'.$this->add('xStore/Model_MaterialRequestSent_Processed')->addCondition('from_department_id',$_GET['department_id'])->myCounts(true,false));
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/completed','Completed'.$this->add('xStore/Model_MaterialRequestSent_Completed')->addCondition('from_department_id',$_GET['department_id'])->myCounts(true,false));
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/cancelled','Cancelled'.$this->add('xStore/Model_MaterialRequestSent_Cancelled')->addCondition('from_department_id',$_GET['department_id'])->myCounts(true,false));
		$tabs->addTabURL('xStore/page/owner/materialrequestsent/return','Return'.$this->add('xStore/Model_MaterialRequestSent_Return')->addCondition('from_department_id',$_GET['department_id'])->myCounts(true,false));














	}
}