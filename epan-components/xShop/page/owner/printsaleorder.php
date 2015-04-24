<?php

class page_xShop_page_owner_printsaleorder extends Page{

	function init(){
		parent::init();

		$order_id = $this->api->StickyGET('saleorder_id');
		if(!$order_id) $this->add('View_Warning')->set('Order Not Found');

		$order=$this->add('xShop/Model_Order')->load($order_id);
		$print=$this->add('xShop/View_PrintOrder');
		$print->setModel($order);
		
	}
}
	
