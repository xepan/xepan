<?php
class page_xStore_page_owner_materialrequest extends page_xStore_page_owner_main {
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small> Manage Your Material Request</small>');

		$tabs=$this->app->layout->add('Tabs');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent','Sent');
		$tabs->addTabURL('xStore_page_owner_materialrequestreceived','Received');
		
	}

}