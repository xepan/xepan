<?php
class page_xShop_page_owner_order_submitted extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		$this->add('PageHelp',array('page'=>'order_submitted'));
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->setModel('xShop/Model_Order_Submitted');
		$crud->add('xHR/Controller_Acl');
	}
}		