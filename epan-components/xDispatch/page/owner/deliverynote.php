<?php
class page_xDispatch_page_owner_deliverynote extends page_xDispatch_page_owner_main {
	function init(){
		parent::init();
		$this->app->title=$this->api->current_department['name'] .': Delivery Notes';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Delivery Note <small> Manage your Delivery Reports   </small>');
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('xDispatch_page_owner_deliverynote_submitted','Submitted'.$this->add('xDispatch/Model_DeliveryNote_Submitted')->myCounts(true,false));
		// $tabs->addTabURL('xDispatch_page_owner_deliverynote_received','Received');
		$tabs->addTabURL('xDispatch_page_owner_deliverynote_completed','Completed'.$this->add('xDispatch/Model_DeliveryNote_Completed')->myCounts(true,false));
		// $this->add('CRUD')->setModel('xDispatch/Model_DeliveryNote');

	}

}