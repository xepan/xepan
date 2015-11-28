<?php
class page_xBlog_page_owner_dashboard extends page_xBlog_page_owner_main{
	function page_index(){
		// parent::init();
		$this->app->title='xBlog  : Dashboard';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-dashboard icon-gauge"></i> xBlog Dashboard');

		$tab=$this->add('Tabs');
		// $tab->addTabURL('./blogCategory','Category');
		$tab->addTabURL('./blog','Blogs');
		$tab->addTabURL('./blogConfig','Configuration');
			
	}
	function page_blog(){
		$crud = $this->add('CRUD',array('grid_class'=>'xBlog/Grid_BlogPost'));
		$crud ->setModel('xBlog/BlogPost');
		$grid=$crud->grid;
		if($grid->hasColumn('item_name'))$grid->removeColumn('item_name');
		if($grid->hasColumn('related_document'))$grid->removeColumn('related_document');
	}
	// function page_blogCategory(){
	// 	$crud = $this->add('CRUD');
	// 	$crud->setModel('xBlog/BlogCategory');

	// 	$grid=$crud->grid;
		
	// 	if($grid->hasColumn('item_name'))$grid->removeColumn('item_name');
	// 	if($grid->hasColumn('related_document'))$grid->removeColumn('related_document');
	// 	if($grid->hasColumn('created_by'))$grid->removeColumn('created_by');
	// }

	function page_blogConfig(){
		$config_model=$this->add('xBlog/Model_Configuration');

		$form=$this->add('Form_Stacked');
		$form->setModel($config_model,array('disqus_code'));
		$form->addSubmit('Update');
		if($form->Submitted()){
			$form->Update();
			$form->js(null,$form->js()->reload())->univ()->successMessage('Update Information')->execute();
		}
		$form->addClass('panel panel-default');
		$form->addStyle('padding','20px');
	}
}