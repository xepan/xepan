<?php
namespace xBlog;
class View_Lister_BlogCategory extends \CompleteLister{
	public $html_attributes=array(); // ONLY Available in server side components

	function init(){
		parent::init();
	}

	function setModel($model){
		parent::setModel($model);
	}
	
	function formatRow(){
		$detail_url = $this->app->url(null,array('category_id'=>$this->model->id,'?subpage'=>$this->html_attributes['category-post-page']))->getURL();
		// throw new \Exception($detail_url, 1);
		$count=$this->model->ref('xBlog/BlogPost')->count()->getOne();

		$this->current_row_html['xblog-category-anchor_page']=$detail_url;
		$this->current_row_html['cat_name']=$this->model['name'];
		$this->current_row_html['cat_post_count']=$count;

		parent::formatRow();
	} 

	function defaultTemplate(){
		$l=$this->api->locate('addons',__NAMESPACE__, 'location');
		$this->api->pathfinder->addLocation(
			$this->api->locate('addons',__NAMESPACE__),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css',
		  		'js'=>'templates/js'
				)
			)->setParent($l);
		return array('view/blogcategory');
	}
}