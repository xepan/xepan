<?php

class page_xCRM_page_owner_ticket extends page_componentBase_page_owner_main {
	function init(){
		parent::init();
		$this->app->title=$this->api->current_department['name'] .': Support Ticket';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Ticket Management <small> Manage your customer complains </small>');

		$tab = $this->add('Tabs');
		$tab->addTabURL('xCRM/page/owner/ticket/draft','Draft '.$this->add('xCRM/Model_Ticket_Draft')->myCounts(true,false));
		$tab->addTabURL('xCRM/page/owner/ticket_submitted','Submiited '.$this->add('xCRM/Model_Ticket_Submitted')->myCounts(true,false));
		$tab->addTabURL('xCRM/page/owner/ticket_assigned','Assigned'.$this->add('xCRM/Model_Ticket_Assigned')->myCounts(true,false));
		$tab->addTabURL('xCRM/page/owner/ticket_solved','Solved '.$this->add('xCRM/Model_Ticket_Solved')->myCounts(true,false));
		$tab->addTabURL('xCRM/page/owner/ticket_canceled','Cancelled '.$this->add('xCRM/Model_Ticket_Canceled')->myCounts(true,false));
		

	}
}