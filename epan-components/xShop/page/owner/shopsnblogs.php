<?php

class page_xShop_page_owner_shopsnblogs extends page_xShop_page_owner_main {
	
	function init(){
		parent::init();
		
		$this->app->title=$this->api->current_department['name'] .': Shops & Blogs';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Shops & Blogs Management <small> Manage your shops and blogs here </small>');

		$tabs= $this->app->layout->add('Tabs');
		$shop_tab = $tabs->addTabURL('./shops','Shops');
		$shop_tab = $tabs->addTabURL('./blogs','Blogs');
	}

	function page_shops(){
		$crud= $this->add('CRUD',array('grid_class'=>'xShop/Grid_Shop'));
		$crud->setModel('xShop/Shop');

		$cf_crud = $crud->addRef('xShop/CustomFields',array('label'=>'Custom Fields'));
		$sp_crud = $crud->addRef('xShop/Specification',array('label'=>'Specifications'));
		$itemoffer_crud=$crud->addRef('xShop/ItemOffer',array('label'=>'Item Offers'));
		if(!$crud->isEditing()){
			$crud->grid->addColumn('expander','configuration',array("descr"=>"Configuration",'icon'=>'cog'));
			$crud->grid->addColumn('expander','tax',array("descr"=>"Taxs",'icon'=>'money'));
			$crud->grid->addColumn('expander','priority',array("descr"=>"Priority",'icon'=>'signal'));
		}

		$crud->grid->addQuickSearch(array('name'));
		$crud->grid->addPaginator($ipp=50);
        $crud->add('xHR/Controller_Acl');
		
	}

	function page_blogs(){
		$crud= $this->add('CRUD',array('grid_class'=>'xShop/Grid_Blog'));
		$crud->setModel('xShop/Blog');

		if(!$crud->isEditing()){
			$crud->grid->addColumn('expander','configuration',array("descr"=>"Configuration",'icon'=>'cog'));
		}

		$crud->grid->addQuickSearch(array('name'));
		$crud->grid->addPaginator($ipp=50);
	}

	function page_shops_configuration(){
		$this->page_blogs_configuration();
	}
	
	function page_shops_tax(){
		$tax = $this->add('xShop/Model_Tax');
		$crud = $this->add('CRUD');
		$crud->setModel($tax,array('name','value'));
	}

	function page_shops_priority(){
		$priority = $this->add('xShop/Model_Priority');
		$crud = $this->add('CRUD');
		$crud->setModel($priority,array('name','value'));
	}

	function page_blogs_configuration(){
		$application_id = $this->api->StickyGET('xshop_application_id');
		$config_model=$this->add('xShop/Model_Configuration')->addCondition('application_id',$application_id)->tryLoadAny();
		$form=$this->add('Form');
		$form->setModel($config_model);
		$form->addSubmit('Update');
		if($form->Submitted()){
			// throw new \Exception("Error Processing Request");
			$form->Update();
			$form->js()->univ()->successMessage('Update Successfully')->execute();	
		}
		$form->addClass('panel panel-default');
		$form->addStyle('padding','20px');
	}

}