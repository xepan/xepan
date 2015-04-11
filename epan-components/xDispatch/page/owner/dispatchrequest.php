<?php
class page_xDispatch_page_owner_dispatchrequest extends page_xDispatch_page_owner_main {
	function init(){
		parent::init();
		
		$this->api->stickyGET('department_id');

		$dr_items = $this->add('xDispatch/Model_DispatchRequestItem')
			->addCondition('status','to_receive');

		$tabs=$this->add('Tabs');
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_toreceive','To Receive'.$dr_items->myCounts(true,false));
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_received','Received'.$this->add('xDispatch/Model_DispatchRequest_Received')->myCounts(true,false));
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_partialcomplete','Partial Complete'.$this->add('xDispatch/Model_DispatchRequest_PartialComplete')->myCounts(true,false));
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_complete','Complete'.$this->add('xDispatch/Model_DispatchRequest_Completed')->myCounts(true,false));
		$tabs->addTabURL('xDispatch_page_owner_dispatchrequest_cancel','Cancel'.$this->add('xDispatch/Model_DispatchRequest_Cancelled')->myCounts(true,false));
	}

}