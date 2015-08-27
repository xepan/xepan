<?php
class page_xShop_page_owner_order_processing extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		$this->add('PageHelp',array('page'=>'order_processing'));

		$processing_orders = $this->add('xShop/Model_Order_Processing');

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->setModel($processing_orders,array('member_id','currency_id','order_summary','termsandcondition_id'),array('name','created_at','member','currency','net_amount','tax','gross_amount','discount_voucher_amount','total_amount','last_action','created_by','orderitem_count'));
		$crud->add('xHR/Controller_Acl');
	}
}		