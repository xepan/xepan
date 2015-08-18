<?php
class page_xCRM_page_owner_ticket_solved extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_solved = $this->add('xCRM/Model_Ticket_Solved');
		$ticket_solved->setOrder('created_at','desc');
		$crud = $this->add('CRUD',array('grid_class'=>'xCRM/Grid_Ticket'));
		$crud->setModel($ticket_solved,array('customer_id','priority','subject','message'),array('name','customer','priority','subject','message'));
		$crud->add('xHR/Controller_Acl');
	}
}		