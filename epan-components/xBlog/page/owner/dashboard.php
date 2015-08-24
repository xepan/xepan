<?php
class page_xBlog_page__owner_dashboard extends page_xBlog_page_owner_main{
	function page_index(){
		// parent::init();
		$this->app->title='xBlog  : Dashboard';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-dashboard icon-gauge"></i> xBlog Dashboard');

		$tab=$this->add('Tabs');
		$tab->addTabURL('./blog','Blogs');
		$tab->addTabURL('./blogCategory','Category');
		$tab->addTabURL('./blogConfig','Configuration');
			
	}
	function page_blog(){
		$crud = $this->add('CRUD');
		$crud ->setModel('xBlog/BlogPost');
		$grid=$crud->grid;
		if($grid->hasColumn('item_name'))$grid->removeColumn('item_name');
		if($grid->hasColumn('related_document'))$grid->removeColumn('related_document');
	}
	function page_blogCategory(){
		$crud = $this->add('CRUD');
		$crud->setModel('xBlog/BlogCategory');

		$grid=$crud->grid;
		
		if($grid->hasColumn('item_name'))$grid->removeColumn('item_name');
		if($grid->hasColumn('related_document'))$grid->removeColumn('related_document');
		if($grid->hasColumn('created_by'))$grid->removeColumn('created_by');
	}

	function page_blogConfig(){
		$crud=$this->add('CRUD');
		$crud->setModel('xBlog/Configuration');
	}
}