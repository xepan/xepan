<?php

namespace xBlog;

class View_Tools_BlogPostDetails extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();

		$post_id=$this->api->stickyGET('post_id');

		// $this->add('Button','reload')->onClick(function(){
		// 	return $this->js()->reload(['review'=>true,
		// 								'rating'=>3,
		// 								'post_id'=>1]);
		// });				

		if($_GET['review']){
			if(!$this->updateReview())
				$this->js()->univ()->errorMessage('You can\'t add more reviews');
		}
		// throw new \Exception($post_id, 1);
		$config_model=$this->add('xBlog/Model_Configuration');
		$config_model->tryLoadAny();
		$post_model=$this->add('xBlog/Model_BlogPost');
		$post_model->tryLoad($post_id);
		
		if(!$post_model->loaded()){
			$this->add('View_Error')->set('Record could not be loaded');
			return;
		}

		//Set Tool Custom Option 
		$this->template->trySet('post_id',$post_id);
		$this->template->trySet('auth',$this->html_attributes['show-post-review-auth']);
		$this->template->trySet('xdays',$this->html_attributes['show-post-review-allow-days']?:1);
		$this->template->trySet('subpage',$_GET['subpage']);

		
		$this->template->trySet('name',$post_model['name']);
		$this->template->trySet('post_date',date('d-m-Y',strtotime($post_model['created_at'])));
		$this->template->trySet('author',$post_model['author']);
		// $this->template->trySetHTML('description',$post_model['description']);

		

		$post_description = $post_model['description'];
		
		if( $this->api->edit_mode == true ){
			$this->js(true)->_load('xblogContentUpdate1');
			$str = '<div class=" xBlog-epan-container epan-container epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding ui-selected xblog-post-detail-content-live-edit" component_type="Container" contenteditable="true"  id="xblog_post_detail_content_live_edit_'.$post_model['id'].'">';
			$str.= $post_description;
			$str.="</div>";
									
			$btn = 'onclick="javascript:$(this).univ().blogPostDetailUpdate(';
			$btn.= '\'xblog_post_detail_content_live_edit_'.$post_model['id'].'\' , \''.$post_model['id'].'\')"';
			$str.='<div id="xblog_post_detail_live_edit_update" class="btn btn-danger xBlog-post-detail-button  btn-block" '.$btn.'>Update</div>';
			$post_description = $str;
		}
		
		$this->template->trySetHtml('container',$post_description);

		//===========================COMMENTS API ===========================
		if($this->html_attributes['show-post-comment']){
			if($config_model['disqus_code'])
				$this->template->trySetHTML('xshop_item_discus',$config_model['disqus_code']);
			else 
				$this->template->trySetHTML('xshop_item_discus',"<div class='alert alert-warning'>Place Your Discus Code and Select Comment Api in Item or Configuration</div>");
		}

		if(!$this->html_attributes['show-post-review']){
			$this->template->trySet('review_section',"");
		}	
		// throw new \Exception("Error Processing Request", 1);
		$this->template->trySet('id',$post_id);
		$review=$this->add('xBlog/Model_BlogPostReview');
		$review->addCondition('post_id',$_GET['post_id']);
		$review->tryLoadAny();
		// $review->setOrder('id','desc');
		$this->template->trySet('reviews_value',$review['review']);
	}

	function updateReview(){
		$post_id = $this->api->stickyGET('post_id');
		$rating = $this->api->stickyGET('rating');

		$auth = $this->html_attributes['show-post-review-auth'];
		$days = $this->html_attributes['show-post-review-allow-days']?:1;

		// if($auth and !$this->api->auth->isLoggedIn()){
		// 	echo false;
		// 	// exit;
		// }	


		$current_ip = getenv('HTTP_CLIENT_IP')?:
					getenv('HTTP_X_FORWARDED_FOR')?:
					getenv('HTTP_X_FORWARDED')?:
					getenv('HTTP_FORWARDED_FOR')?:
					getenv('HTTP_FORWARDED')?:
					getenv('REMOTE_ADDR');

		$review_model=$this->add('xBlog/Model_BlogPostReview');
		$review_model->addCondition('post_id',$post_id);
		$review_model->addCondition('ip',$current_ip);

		//Save Review First time
		if($review_model->count()->getOne() == 0){
			$review_model['review'] = $rating;
			$review_model['date'] = $this->api->now;
			$review_model->save();
			// echo true;

		}else{
			$review_model->setOrder('date','desc');
			$review_model->setLimit(1);
			$review_model->tryLoadAny();

			$day_diff = $this->api->my_date_diff($this->api->now, $review_model['date']);
			$day_diff = $day_diff['days'];
			if($days == 1){
				// echo false;
			}

			// if($days < $day_diff){
				$b = $this->add('xBlog/Model_BlogPostReview');
				$b['review'] = $rating;
				$b['date'] = $this->api->now;
				$b['ip'] = $current_ip;
				$b['post_id'] = $post_id;
				$b->save();
				
				// echo true;
				
			// }

		}
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