<?php
class page_xCRM_page_owner_ticket_draft extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_draft = $this->add('xCRM/Model_Ticket_Draft');
		$ticket_draft->setOrder('created_at','desc');
		$crud = $this->add('CRUD',array('grid_class'=>'xCRM/Grid_Ticket'));
		$crud->setModel($ticket_draft,array('customer_id','priority','subject','message'),array('name','customer','priority','subject','message'));

		$crud->add('xHR/Controller_Acl');
	}
}		