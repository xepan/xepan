<?php

class page_xShop_page_owner_category extends page_xShop_page_owner_main{

	function init(){
		parent::init();
		
		$this->app->title=$this->api->current_department['name'] .': Item Categories';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Item Category Management <small> Manage Item Categories </small>');
		
		$application_id=$this->api->recall('xshop_application_id');
		
		//Badges 
		$badge_view = $this->add('xShop/View_Badges_CategoryPage');
		
		$category_model = $this->add('xShop/Model_Category');
		$category_model->addCondition('application_id',$application_id);	
		$category_model->setOrder('id','desc');
						
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Category'));
		$crud->setModel($category_model,array('parent_id','name','order_no','is_active','meta_title','meta_description','meta_keywords','image_url_id','alt_text','description'),array('name','parent','order_no','is_active'));
		
		if($crud->isEditing()){	
			$parent_model = $crud->form->getElement('parent_id')->getModel();
			$parent_model->title_field='category_name';
			$parent_model->addCondition('application_id',$application_id);
		}
		
		$crud->add('xHR/Controller_Acl');
		
	}

}