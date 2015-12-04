<?php
namespace xBlog;
class Grid_BlogPost extends \Grid{
	function init(){
		parent::init();

	}

	function setModel($model){
		$m=parent::setModel($model);

		if($this->hasColumn('item_name'))$this->removeColumn('item_name');
		if($this->hasColumn('created_by'))$this->removeColumn('created_by');
		if($this->hasColumn('related_document'))$this->removeColumn('related_document');
		if($this->hasColumn('updated_date'))$this->removeColumn('updated_date');
		if($this->hasColumn('created_date'))$this->removeColumn('created_date');
	}
	function recursiveRender(){
		$cat_btn= $this->addButton("Blog Category Management");
		if($cat_btn->isClicked()){
			$this->js()->univ()->frameURL('Blog Category',$this->api->url('xBlog_page_owner_blogcategory'))->execute();
		}
		parent::recursiveRender();
	}
}