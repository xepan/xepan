<?php

class page_xShop_page_owner_printsaleorder extends Page{

	function init(){
		parent::init();
		$print_ordre_array = [];
		if($_GET['printAll']){

			$print_order  = $this->add('xShop/Model_Order');
            if($_GET['from_date'])
                $print_order->addCondition('created_at','>',$_GET['from_date']);
            if($_GET['to_date'])
                $print_order->addCondition('created_at','<',$_GET['to_date']);
            if($_GET['member_id'])
                $print_order->addCondition('member_id',$_GET['member_id']);

            $all_order = $print_order->_dsql()->del('fields')->field('id')->getAll();
           	$print_ordre_array = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($all_order)),false);
		}else{
			
			$print_ordre_array[] = $order_id = $this->api->StickyGET('saleorder_id');
		}

		
		foreach ($print_ordre_array as $key => $order_id) {

				$sale_performa = $this->api->StickyGET('sale_performa');
				if(!$order_id) {
					$this->add('View_Warning')->set('Order Not Found');
				}

				$order=$this->add('xShop/Model_Order')->load($order_id);

				if($sale_performa == 0){
					$css=array(
						'templates/css/epan.css',
						'templates/css/compact.css'
					);
					
					foreach ($css as $css_file) {
						$link = $this->add('View')->setElement('link');
						$link->setAttr('rel',"stylesheet");
						$link->setAttr('type',"text/css");
						$link->setAttr('href',$css_file);
					}

					$order_view = $this->add('xShop/View_Order');
					$order_view->setModel($order);
				}

				if($sale_performa == 1){
					echo $order->parseEmailBody();
				}	
		}

		exit;
		
	}
}