<?php

namespace xBlog;

class View_Tools_BlogPost extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();
		$post_model=$this->add('xBlog/Model_BlogPost');
		$post_model->addCondition('is_publish',true);
		$post_model->tryLoadAny();
		
		$lister=$this->add('xBlog/View_Lister_BlogPost',array('html_attributes'=>$this->html_attributes));
		
		
		$lister->setModel($post_model);
	}

	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html

}