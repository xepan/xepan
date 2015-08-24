<?php

class page_xBlog_page_owner_blogcategory extends page_xBlog_page_owner_main{
	function init(){
		parent::init();

		$crud = $this->add('CRUD');
		$crud->setModel('xBlog/BlogCategory');
	}
}