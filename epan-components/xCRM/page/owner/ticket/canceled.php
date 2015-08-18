<?php
class page_xCRM_page_owner_ticket_canceled extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_canceled = $this->add('xCRM/Model_Ticket_Canceled');
		$ticket_canceled->->setOrder('created_at','desc');
		$crud = $this->add('CRUD',array('grid_class'=>'xCRM/Grid_Ticket'));
		$crud->setModel($ticket_canceled,array('customer_id','priority','subject','message'),array('name','customer','priority','subject','message'));
		$crud->add('xHR/Controller_Acl');
	}
}		