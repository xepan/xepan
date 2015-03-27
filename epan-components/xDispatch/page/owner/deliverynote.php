<?php
class page_xDispatch_page_owner_deliverynote extends page_xDispatch_page_owner_main {
	function init(){
		parent::init();

		$tabs=$this->app->layout->add('Tabs');
		$tabs->addTabURL('xDispatch_page_owner_deliverynote_submitted','Submitted');
		// $tabs->addTabURL('xDispatch_page_owner_deliverynote_received','Received');
		$tabs->addTabURL('xDispatch_page_owner_deliverynote_completed','Completed');
		// $this->add('CRUD')->setModel('xDispatch/Model_DeliveryNote');

	}

}