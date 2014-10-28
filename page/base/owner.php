<?php
class page_base_owner extends Page {
	public $page_heading;
	public $page_subheading;
	public $menu;
	function init(){
		parent::init();

		if(!$this->api->auth->isLoggedIn()){
			$this->api->template->tryDel('admin_template');
		}

		$user_model = $this->add('Model_Users')
						->addCondition('type','<>','FrontEndUser')
						->addCondition('is_active',true)
						;
		$this->api->auth->setModel($user_model,'username','password');
		$this->api->auth->addHook('updateForm',function($auth){
			$auth->form->addClass('stacked');
		});
		$this->api->auth->check();
		$this->api->current_website = $this->api->auth->model->ref('epan_id');
		$this->api->current_page = $this->api->current_website->ref('EpanPage');
		$this->api->memorize('website_requested',$this->api->current_website['name']);
		$this->api->load_plugins();
		if(!$this->api->isAjaxOutput()){
			$this->menu = $this->api->add('View_Menu',null,'menu',array('owner/menu'));
			if($this->api->getConfig('default_site') != $this->api->current_website['name'])
				$this->menu->template->tryDel('update_menu');
		}
	}

	function render(){
		$this->api->template->appendHTML('js_include','<link type="text/css" href="elfinder/css/elfinder.min.css" rel="stylesheet" />'."\n");
			$this->api->template->appendHTML('js_include','<link type="text/css" href="elfinder/css/theme.css" rel="stylesheet" />'."\n");
			$this->api->template->appendHTML('js_include','<script src="elfinder/js/elfinder.min.js"></script>'."\n");
		parent::render();
	}
}