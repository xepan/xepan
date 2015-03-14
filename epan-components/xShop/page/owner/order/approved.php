<?php
class page_xShop_page_owner_order_approved extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$this->add('PageHelp',array('page'=>'order_approve'))->set('These Orders are approved, items JOBCARDS CREATED, waiting for their respective FIRST Departments to receive. On Any on of item received the status of Order will be "Processing"');
		$approved_order = $this->add('xShop/Model_Order_Approved');

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->setModel($approved_order);
		$crud->add('xHR/Controller_Acl');
	}
}		