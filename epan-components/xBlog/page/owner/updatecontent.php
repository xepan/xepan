<?php

class page_xBlog_page_owner_updatecontent extends page_componentBase_page_update {

	function init(){
		parent::init();

		// print_r($_POST);
		$post_model = $this->add('xBlog/Model_BlogPost');
		// throw new \Exception("Error Processing Request".$_post['xshop_item_id']);
		// throw new \Exception(urldecode($_POST['body_html']), 1);
		
		$result = $post_model->updateContent($_POST['xblog_post_id'],urldecode(trim( $_POST['body_html'] ) ) );
		if($result == 'true'){
			echo "updated";
		}else{
			echo "none";	
		}
		// throw new \Exception($_POST['body_html']);
		exit();
	}	
}		