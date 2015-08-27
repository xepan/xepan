<?php

namespace xBlog;

class View_Tools_BlogCategory extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();
		$cat_model=$this->add('xBlog/Model_BlogCategory');
		$cat_model->addCondition('is_active',true);
		$cat_model->tryLoadAny();
		
		$lister=$this->add('xBlog/View_Lister_BlogCategory',array('html_attributes'=>$this->html_attributes));
		
		
		$lister->setModel($cat_model);
	}

	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}