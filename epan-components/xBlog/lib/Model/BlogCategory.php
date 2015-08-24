<?php
namespace xBlog;
class Model_BlogCategory extends \Model_Document{
	public $table='xblog_categories';
	public $status=array();
	public $root_document_name="xBlog\BlogCategory";

	function init(){
		parent::init();
		$this->hasOne('xBlog/ParentBlogCategory','parent_category_id')->mandatory(true);
		$this->addField('name')->mandatory(true);
		$this->addField('is_acitve')->type('boolean');

		$this->hasMany('xBlog/BlogPost','category_id');
		$this->hasMany('xBlog/BlogCategory','parent_category_id',null,'SubCategories');
		// $this->add('dynamic_model/Controller_AutoCreator');
	}
}