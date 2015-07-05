<?php
class page_xShop_page_owner_order_processed extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		$this->add('PageHelp',array('page'=>'order_processed'))->set('These Orders are approved, items JOBCARDS CREATED, waiting for their respective FIRST Departments to receive. On Any on of item received the status of Order will be "Processed"');
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->setModel('xShop/Model_Order_Processed',array('member_id','order_summary','termsandcondition_id'),array('name','created_at','member','net_amount','tax','gross_amount','discount_voucher_amount','total_amount','last_action','created_by','orderitem_count'));
		$crud->add('xHR/Controller_Acl');
	}
}		