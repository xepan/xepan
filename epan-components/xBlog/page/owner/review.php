<?php

class page_xBlog_page_owner_review extends  page_xBlog_page_owner_main{
	function init(){
		parent::init();

		//OPtions 
			//IP Restriction 
				//Posible value x days or onlyOneTime
			//Authentication
				// true of false

		if($_GET['authentication'] and !$this->api->auth->isLoggedIn()){
			echo "authentication_failed"
			exit;
		}	

		$post_id = $this->api->stickeyGET('post_id');
		$review = $this->api->stickeyGET('review');

		$current_ip = getenv('HTTP_CLIENT_IP')?:
					getenv('HTTP_X_FORWARDED_FOR')?:
					getenv('HTTP_X_FORWARDED')?:
					getenv('HTTP_FORWARDED_FOR')?:
					getenv('HTTP_FORWARDED')?:
					getenv('REMOTE_ADDR');

		$days = 1;
		if($_GET['days'])
			$days = $_GET['days']; //xdays

		$review_model=$this->add('xBlog/Model_BlogPostReview');
		$review_model=$this->add('xBlog/Model_BlogPostReview');
		$review_model->addCondition('post_id',$post_id);
		$review_model->addCondition('ip',$current_ip);

		//Save Review First time
		if($review_model->count()->getOne() == 0){
			$review_model['review'] = $review;
			$review_model['date'] = $this->api->now;
			$review_model->save();
			echo "saved";
			exit;

		}else{

			$review_model->setOrder('desc','date');
			$review_model->setLimit(1);
			$review_model->tryLoadAny();

			$day_diff = date_diff($this->api->now, $review_model['date']);

			if($days == 1){
				echo "review_added_before";
				exit;
			}

			if($days < $day_diff){
				$b = $this->add('xBlog/Model_BlogPostReview');
				$b['review'] = $review;
				$b['date'] = $this->api->now;
				$b['ip'] = $current_ip;
				$b['post_id'] = $post_id;
				$b->save();
				
				echo "saved";
				exit;
			}

		}

	}
}