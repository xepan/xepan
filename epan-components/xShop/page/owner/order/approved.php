<?php
class page_xShop_page_owner_order_approved extends page_xShop_page_owner_main{
	function init(){
		parent::init();

		$this->add('PageHelp',array('page'=>'order_approve'));
		$approved_order = $this->add('xShop/Model_Order_Approved');

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->setModel($approved_order,array('member_id','order_summary','termsandcondition_id','delivery_date','order_from'),array('name','created_at','member','net_amount','last_action','created_by','orderitem_count'));
		$crud->add('xHR/Controller_Acl');
	}
}		