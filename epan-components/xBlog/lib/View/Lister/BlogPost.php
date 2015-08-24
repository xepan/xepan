<?php
namespace xBlog;
class View_Lister_BlogPost extends \CompleteLister{
	public $html_attributes=array(); // ONLY Available in server side components

	function init(){
		parent::init();
	}

	function setModel($model){
		parent::setModel($model);
	}
	
	function formatRow(){
		$detail_url = $this->app->url(null,array('post_id'=>$this->model->id,'subpage'=>$this->html_attributes['blog-detail-page']))->getURL();
		// throw new \Exception($detail_url, 1);
		
		$this->current_row_html['xblog-post-anchor_page']=$detail_url;

		$this->current_row_html['name']=$this->model['name'];
		$this->current_row_html['post_date']=date('d-m-Y',strtotime($this->model['created_at']));
		$this->current_row_html['author']=$this->model['author'];
		$this->current_row_html['description']=$this->model['description'];
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
		return array('view/blogpost');
	}
}