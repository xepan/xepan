<?php
class page_xCRM_page_owner_ticket_draft extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_draft = $this->add('xCRM/Model_Ticket_Draft');

		$crud = $this->add('CRUD');
		$crud->setModel($ticket_draft);
		$crud->add('xHR/Controller_Acl');
	}
}		