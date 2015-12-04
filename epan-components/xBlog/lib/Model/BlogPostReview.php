<?php
namespace xBlog;
class Model_BlogPostReview extends \Model_Table{
	public $table="xblog_post_review";
	function init(){
		parent::init();
		$this->hasOne('xBlog/BlogPost','post_id');
		$this->addField('ip');
		$this->addField('review');
		$this->addField('date')->type('date')->defaultValue($this->api->now);

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}