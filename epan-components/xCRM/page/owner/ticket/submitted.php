<?php
class page_xCRM_page_owner_ticket_submitted extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_submitted = $this->add('xCRM/Model_Ticket_Submitted');

		$crud = $this->add('CRUD',array('grid_class'=>'xCRM/Grid_Ticket'));
		$crud->setModel($ticket_submitted,array('customer_id','priority','subject','message'),array('name','customer','priority','subject','message'));
		$crud->add('xHR/Controller_Acl');
	}
}		