<?php
class page_xShop_page_owner_order_all extends page_xShop_page_owner_main{
	function init(){
		parent::init();
		// $this->add('PageHelp',array('page'=>'order_all'));
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Order'));
		$crud->setModel('xShop/Model_Order',array('member_id','order_summary','termsandcondition_id'),array('name','created_at','member','net_amount','last_action','created_by','orderitem_count','order_from'));
		$crud->add('xHR/Controller_Acl');
	}
}		