<?php

class page_xShop_page_owner_blogcategory extends page_xShop_page_owner_main{

	function init(){
		parent::init();
		
		$this->app->title=$this->api->current_department['name'] .': Blog Categories';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Blog Category Management <small> Manage Blog Categories </small>');
		
		//Badges 
		// $badge_view = $this->add('xShop/View_Badges_CategoryPage');
		$app = $this->add('xShop/Model_BlogApplication')->tryLoadAny();

		$category_model = $this->add('xShop/Model_BlogCategory');
		$category_model->setOrder('id','desc');
			
		$crud=$this->add('CRUD',array('grid_class'=>'xShop/Grid_Category'));
		$crud->setModel($category_model,array('parent_id','name','order_no','is_active','meta_title','meta_description','meta_keywords','image_url_id','alt_text','description'),array('name','parent','order_no','is_active'));
		
		if($crud->isEditing()){
			$parent_model = $crud->form->getElement('parent_id')->getModel();
			$parent_model->title_field='category_name';
			$parent_model->addCondition('application_id',$app->id);
		}
		
		$crud->add('xHR/Controller_Acl');
		
	}

}