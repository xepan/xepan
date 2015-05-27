<?php
class page_xCRM_page_owner_ticket_submitted extends page_xCRM_page_owner_main{
	
	function init(){
		parent::init();

		$ticket_submitted = $this->add('xCRM/Model_Ticket_Submitted');

		$crud = $this->add('CRUD',array('grid_class'=>'xCRM/Grid_Ticket'));
		$crud->setModel($ticket_submitted,array('name','uid','from','from_id',
												'from_email','from_name','to',
												'to_id','to_email','cc','bcc',
												'subject','message','priority')
										,array());
		$crud->add('xHR/Controller_Acl');
	}
}		