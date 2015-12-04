<?php

namespace xBlog;

class Model_Configuration extends \Model_Table {
	public $table= "xblog_configuration";
	function init(){
		parent::init();

		//TODO for Mutiple Epan website
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
			
		$f = $this->addField('disqus_code')->type('text')->caption('Place the Disqus code')->PlaceHolder('Place your Disqus Code here..')->hint('Place your Discus code here')->group('x~12~<i class="fa fa-comments"></i> Website Comment System Config'); 		
		$f->icon = "fa fa-comment~blue";
			
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function loadDefaults($application){
		$data= file_get_contents(getcwd().'/epan-components/xShop/default-layouts.xepan');
		$arr = json_decode($data,true);
		foreach ($arr as $dg) {
			unset($dg['id']);
			unset($dg['epan_id']);
			$dg['application_id'] = $application->id;
			$this->newInstance()->set($dg)->save();
		}
	}
	
}
