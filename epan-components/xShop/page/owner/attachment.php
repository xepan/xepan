<?php

class page_xShop_page_owner_attachment extends page_xShop_page_owner_main{
    function init(){
		parent::init();
        
        $di = $this->api->stickyGET('department_id');
        $order_id = $this->api->stickyGET('id');
        $order_item_id = $this->api->stickyGET('xshop_orderDetails_id');
        
        if($order_id){
            $order = $this->add('xShop/Model_Order')->load($order_id);
            $this->add('View')->set("Member name = ".$order['member']);
            $attachment = $this->add('xShop/Model_SalesOrderAttachment');
        }
        if($order_item_id){
           $attachment = $this->add('xShop/Model_SalesOrderDetailAttachment');    
        }

        $crud = $this->add('CRUD');


        $crud->setModel($attachment);

        if(!$crud->isEditing()){
			$g = $crud->grid;
			$g->addMethod('format_image_thumbnail',function($g,$f){
				$g->current_row_html[$f] = '<a target="_blank" style="height:40px;max-height:40px;" href="'.$g->current_row[$f].'"><img style="height:40px;max-height:40px;" src="'.$g->current_row[$f].'"/></>';
			});
			$g->addFormatter('attachment_url','image_thumbnail');
			$g->addPaginator($ipp=50);
		}
    }
}