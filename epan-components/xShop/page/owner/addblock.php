<?php

class page_xShop_page_owner_addblock extends page_xShop_page_owner_main{

	function page_index(){

		$this->app->title=$this->api->current_department['name'] .': AddBlock';		
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Add Block<small> Manage your add block </small>');

		$crud=$this->app->layout->add('CRUD');
		$crud->setModel('xShop/Model_AddBlock');
		// $crud->add('Controller_FormBeautifier');
		$ref = $crud->addRef('xShop/BlockImages',array('label'=>'Images'));
		// if($ref)
		// 	$ref->add('Controller_FormBeautifier');
	}

	function page_BlockImages(){
		
		$block_id = $this->api->stickyGET('xshop_addblock_id');
		if($block_id){
			$bimg_model = $this->add('xShop/Model_BlockImage');
			$bimg_model->load($block_id);
			$crud_img = $this->add('CRUD');
			$crud_img->setModel($bimg_model);
		}

	}

}