<?php
class page_xCRM_page_owner_ticket_submitted extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_submitted = $this->add('xCRM/Model_Ticket_Submitted');

		$crud = $this->add('CRUD');
		$crud->setModel($ticket_submitted);
		$crud->add('xHR/Controller_Acl');
	}
}		