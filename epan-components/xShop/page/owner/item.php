<?php

class page_xShop_page_owner_item extends page_xShop_page_owner_main{

	function init(){
		parent::init();
		
		$application_id=$this->api->recall('xshop_application_id');
		$this->app->title=$this->api->current_department['name'] .': Items';
	

		//Item
		$bg = $this->add('xShop/View_Badges_ItemPage');
		$item_model = $this->add('xShop/Model_Item');
		$item_model = $item_model->applicationItems($application_id);
		$item_crud = $this->add('CRUD',array('grid_class'=>'xShop/Grid_Item'));
		$item_crud->setModel($item_model,array('name','sku','is_publish','allow_comments','is_saleable'));

		$item_crud->js('reload',$bg->js()->reload());
		//array('name','sku','is_publish','short_description','description','default_qty','default_qty_unit','original_price','sale_price','rank_weight','created_at','expiry_date','allow_attachment','allow_enquiry','allow_saleable','show_offer','show_detail','show_price','show_manufacturer_detail','show_supplier_detail','new','feature','latest','mostviewed','enquiry_send_to_admin','item_enquiry_auto_reply','allow_comments','comment_api','add_custom_button','custom_button_text','custom_button_url','meta_title','meta_description','tags','offer_id','offer_position','is_designable','designer_id','is_template')
	}

	
	function page_details(){
		$item_id=$this->api->stickyGET('xshop_items_id');	
		$item_model = $this->add('xShop/Model_Item');
		$item_model->getItem($item_id);
		$product_view = $this->add('xShop/View_ItemDetail');
		$product_view->setModel($item_model);
	}

}