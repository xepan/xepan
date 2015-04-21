<?php
class page_xCRM_page_owner_ticket_assigned extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_assigned = $this->add('xCRM/Model_Ticket_Assigned');

		$crud = $this->add('CRUD');
		$crud->setModel($ticket_assigned);
		$crud->add('xHR/Controller_Acl');
	}
}		