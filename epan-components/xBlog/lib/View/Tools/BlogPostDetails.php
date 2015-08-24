<?php

namespace xBlog;

class View_Tools_BlogPostDetails extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();

		$post_id=$this->api->StickyGET('post_id');
		// throw new \Exception($post_id, 1);
		$post_model=$this->add('xBlog/Model_BlogPost');
		$post_model->load($post_id);

		$this->template->trySet('name',$post_model['name']);
		$this->template->trySet('post_date',date('d-m-Y',strtotime($post_model['created_at'])));
		$this->template->trySet('author',$post_model['author']);
		// $this->template->trySetHTML('description',$post_model['description']);

		

		$post_description = $post_model['description'];
		
		if( $this->api->edit_mode == true ){
			$this->js(true)->_load('xblogContentUpdate1');
			$str = '<div class="epan-container epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding ui-selected xblog-post-detail-content-live-edit" component_type="Container" contenteditable="true"  id="xblog_post_detail_content_live_edit_'.$post_model['id'].'">';
			$str.= $post_description;
			$str.="</div>";
									
			$btn = 'onclick="javascript:$(this).univ().blogPostDetailUpdate(';
			$btn.= '\'xblog_post_detail_content_live_edit_'.$post_model['id'].'\' , \''.$post_model['id'].'\')"';
			$str.='<div id="xblog_post_detail_live_edit_update" class="btn btn-danger pull-right btn-block" '.$btn.'>Update</div>';
			$post_description = $str;
		}
		
		$this->template->trySetHtml('container',$post_description);
	}

	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		return array('view/blogpostdetails');
	}
}