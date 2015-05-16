<?php

class page_xShop_page_owner_blog extends page_xShop_page_owner_main{

	function init(){
		parent::init();
		
		$application_id=$this->api->recall('xshop_application_id');
		$this->app->title=$this->api->current_department['name'] .': Blogs';
	
		//Item
		$removeColumns = array('application',
							'is_publish',
							'sku',
							'short_description',
							'description',
							'rank_weight',
							'created_at',
							'expiry_date',
							'minimum_order_qty',
							'maximum_order_qty',
							'qty_from_set_only',
							'is_template',
							'is_party_publish',
							'is_saleable',
							'is_purchasable',
							'mantain_inventory',
							'allow_negative_stock',
							'is_productionable',
							'website_display',
							'is_designable',
							'is_attachment_allow',
							'show_detail',
							'show_price',
							'is_visible_sold',
							'is_enquiry_allow',
							'enquiry_send_to_admin',
							'Item_enquiry_auto_reply',
							'allow_comments',
							'negative_qty_allowed',
							
							'warrenty_days',
							'offer',
							'offer_position',
							'new',
							'latest',
							'feature',
							'mostviewed',
							'comment_api',
							'add_custom_button',
							'custom_button_url',
							'custom_button_label',
							'theme_code',
							'reference',
							'watermark_image',
							'watermark_text',
							'watermark_position',
							'watermark_opacity',
							'designs',
							'meta_title',
							'meta_description',
							'tags',
							'terms_condition',
							'theme_code_group_expression',
							
							'original_price',
							'sale_price',
							'qty_unit',
							'designer',

							'item_name',
							'created_by',
							'related_document',
							'updated_date',
							'created_date',
							);

		$bg = $this->add('xShop/View_Badges_BlogPage');
		$blog = $this->add('xShop/Model_Blog');//Item

		$blog_crud = $this->add('CRUD',array('grid_class'=>'xShop/Grid_Blog'));
		$blog_crud->setModel($blog,array('name','code','is_publish','short_description','rank_weight','expiry_date','description','show_detail','allow_comments','comment_api','add_custom_button','custom_button_label','custom_button_url','meta_title','meta_description','tags'));

		// if(!$blog_crud->isEditing()){
		// 	$blog_crud->grid->removeColumns($removeColumns);
		// }

		$blog_crud->js('reload',$bg->js()->reload());
		$blog_crud->add('xHR/Controller_Acl');
		//array('name','sku','is_publish','short_description','description','default_qty','default_qty_unit','original_price','sale_price','rank_weight','created_at','expiry_date','allow_attachment','allow_enquiry','allow_saleable','show_offer','show_detail','show_price','show_manufacturer_detail','show_supplier_detail','new','feature','latest','mostviewed','enquiry_send_to_admin','item_enquiry_auto_reply','allow_comments','comment_api','add_custom_button','custom_button_text','custom_button_url','meta_title','meta_description','tags','offer_id','offer_position','is_designable','designer_id','is_template')
	}

}