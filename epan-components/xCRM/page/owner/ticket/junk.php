<?php
class page_xCRM_page_owner_ticket_junk extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_junk = $this->add('xCRM/Model_Ticket_Junk');

		$crud = $this->add('CRUD');
		$crud->setModel($ticket_junk);
		$crud->add('xHR/Controller_Acl');
	}
}		