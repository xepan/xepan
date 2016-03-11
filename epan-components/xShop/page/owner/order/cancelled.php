<?php
class page_xShop_page_owner_order_cancelled extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		$this->add('PageHelp',array('page'=>'order_cancel'));
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->setModel('xShop/Model_Order_Cancelled',array('member_id','order_summary','termsandcondition_id'),array('name','created_at','member','net_amount','tax','gross_amount','discount_voucher_amount','total_amount','last_action','created_by','orderitem_count','order_from'));
		$crud->add('xHR/Controller_Acl');
	}
}		