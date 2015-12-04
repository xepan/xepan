<?php
class page_xCRM_page_owner_ticket_junk extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_junk = $this->add('xCRM/Model_Ticket_Junk');
		$ticket_junk->setOrder('created_at','desc');
		$crud = $this->add('CRUD',array('grid_class'=>'xCRM/Grid_Ticket'));
		$crud->setModel($ticket_junk,array('customer_id','priority','subject','message'),array('name','customer','priority','subject','message'));
		$crud->add('xHR/Controller_Acl');
	}
}		