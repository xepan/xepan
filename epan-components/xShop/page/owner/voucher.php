<?php

class page_xShop_page_owner_voucher extends page_xShop_page_owner_main{

	function page_index(){

		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_DiscountVoucher'));
		$crud->setModel('xShop/DiscountVoucher');
		// $crud->add('Controller_FormBeautifier');
		if(!$crud->isEditing()){
        	$crud->add('xHR/Controller_Acl');
		}
	}
}