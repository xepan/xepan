<?php
class page_xShop_page_owner_order_cancelled extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		$this->add('PageHelp',array('page'=>'order_cancel'));
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->setModel('xShop/Model_Order_Cancelled');
		$crud->add('xHR/Controller_Acl');
	}
}		