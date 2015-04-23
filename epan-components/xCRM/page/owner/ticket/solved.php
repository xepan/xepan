<?php
class page_xCRM_page_owner_ticket_solved extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_solved = $this->add('xCRM/Model_Ticket_Solved');

		$crud = $this->add('CRUD');
		$crud->setModel($ticket_solved);
		$crud->add('xHR/Controller_Acl');
	}
}		