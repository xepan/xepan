<?php

namespace xBlog;

class View_Tools_BlogPost extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();
		$cat_id=$this->api->StickyGET('category_id');
		// throw new \Exception($post_id, 1);
		$post_model=$this->add('xBlog/Model_BlogPost');
		$post_model->addCondition('is_publish',true);
		if($cat_id)
			$post_model->addCondition('category_id',$cat_id);
		$lister=$this->add('xBlog/View_Lister_BlogPost',array('html_attributes'=>$this->html_attributes));
		$lister->setModel($post_model);

		if(($this->api->auth->isLoggedIn() And $this->api->auth->model['type']>=80) OR $post_model['is_publish']=false){
				$m=$this->add('xBlog/Model_BlogPost');
				$m->addCondition('category_id',$cat_id);
				$m->addCondition('is_publish',false);
				$l=$this->add('xBlog/View_Lister_BlogPost',array('html_attributes'=>$this->html_attributes));
				$l->setModel($m);
		}
	}

	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}