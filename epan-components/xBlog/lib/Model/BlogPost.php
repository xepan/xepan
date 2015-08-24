<?php
namespace xBlog;
class Model_BlogPost extends \Model_Document{
	public $table='xblog_posts';
	public $status=array();
	public $root_document_name='xBlog\Post';

	function init(){
		parent::init();

		$this->hasOne('xBlog/BlogCategory','category_id')->mandatory(true);
		$this->addField('name')->mandatory(true);
		$this->addField('description')->type('text')->display(array('form'=>'RichText'));
		$this->addField('author')->set($this->api->current_employee->id);
		$this->addField('is_publish')->type('boolean');

		$this->hasMany('xBlog/PostDetail','post_id');
		
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function updateContent($id,$content){
		if(!$id) return 'false';

		$post_model = $this->add('xBlog/Model_BlogPost');
		$post_model->tryLoad($id);
		if(!$post_model->loaded()) return 'false';
			
		$post_model['description']=$content=="undefined"?"":$content;
		$post_model->save();
		return 'true';
	}
}