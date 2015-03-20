<?php
class page_xShop_page_owner_order_redesign extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$this->add('PageHelp',array('page'=>'order_approve'));
		$approved_order = $this->add('xShop/Model_Order_Redesign');

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->setModel($approved_order);
		$crud->add('xHR/Controller_Acl');
	}
}		