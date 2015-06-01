<?php
class page_xCRM_page_owner_ticket_assigned extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_assigned = $this->add('xCRM/Model_Ticket_Assigned');

		$crud = $this->add('CRUD',array('grid_class'=>'xCRM/Grid_Ticket'));
		$crud->setModel($ticket_assigned,array('customer_id','priority','subject','message'),array('name','customer','priority','subject','message'));
		$crud->add('xHR/Controller_Acl');
	}
}		