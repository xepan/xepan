<?php
class page_xCRM_page_owner_ticket_canceled extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_canceled = $this->add('xCRM/Model_Ticket_Canceled');

		$crud = $this->add('CRUD');
		$crud->setModel($ticket_canceled);
		$crud->add('xHR/Controller_Acl');
	}
}		