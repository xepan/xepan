<?php
class page_xStore_page_owner_materialrequest extends page_xStore_page_owner_main {
	function init(){
		parent::init();
		
		$this->app->title=$this->api->current_department['name'] .': Material Request';

		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->api->current_department['name']. '<small> Material Requests </small>');
		$this->api->stickyGET('department_id');
		$this->add('PageHelp',array('page'=>'materialrequest'));

		
		$tabs=$this->add('Tabs');
		$tabs->addTabURL('xStore_page_owner_materialrequestsent','Sent');
		$tabs->addTabURL('xStore_page_owner_materialrequestreceived','Received');
		
	}

}