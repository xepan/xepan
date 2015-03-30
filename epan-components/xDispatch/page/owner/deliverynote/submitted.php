<?php

class page_xDispatch_page_owner_deliverynote_submitted extends page_xDispatch_page_owner_main{

	function page_index(){

		$crud=$this->add('CRUD',array('grid_class'=>'xDispatch/Grid_DeliveryNote'));
		$crud->setModel('xDispatch/DeliveryNote_Submitted',array('order','order_id','job_number','name','to_memberdetails','docket_no'));
		$crud->add('xHR/Controller_Acl');
	}
}
