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
		$this->api->template->appendHTML('js_include',
				'
					<link rel="stylesheet" href="elfinder/css/common.css"      type="text/css">
					<link rel="stylesheet" href="elfinder/css/dialog.css"      type="text/css">
					<link rel="stylesheet" href="elfinder/css/toolbar.css"     type="text/css">
					<link rel="stylesheet" href="elfinder/css/navbar.css"      type="text/css">
					<link rel="stylesheet" href="elfinder/css/statusbar.css"   type="text/css">
					<link rel="stylesheet" href="elfinder/css/contextmenu.css" type="text/css">
					<link rel="stylesheet" href="elfinder/css/cwd.css"         type="text/css">
					<link rel="stylesheet" href="elfinder/css/quicklook.css"   type="text/css">
					<link rel="stylesheet" href="elfinder/css/commands.css"    type="text/css">

					<link rel="stylesheet" href="elfinder/css/fonts.css"       type="text/css">
					<link rel="stylesheet" href="elfinder/css/theme.css"       type="text/css">

					<!-- elfinder core -->
					<script src="elfinder/js/elFinder.js"></script>
					<script src="elfinder/js/elFinder.version.js"></script>
					<script src="elfinder/js/jquery.elfinder.js"></script>
					<script src="elfinder/js/elFinder.resources.js"></script>
					<script src="elfinder/js/elFinder.options.js"></script>
					<script src="elfinder/js/elFinder.history.js"></script>
					<script src="elfinder/js/elFinder.command.js"></script>

					<!-- elfinder ui -->
					<script src="elfinder/js/ui/overlay.js"></script>
					<script src="elfinder/js/ui/workzone.js"></script>
					<script src="elfinder/js/ui/navbar.js"></script>
					<script src="elfinder/js/ui/dialog.js"></script>
					<script src="elfinder/js/ui/tree.js"></script>
					<script src="elfinder/js/ui/cwd.js"></script>
					<script src="elfinder/js/ui/toolbar.js"></script>
					<script src="elfinder/js/ui/button.js"></script>
					<script src="elfinder/js/ui/uploadButton.js"></script>
					<script src="elfinder/js/ui/viewbutton.js"></script>
					<script src="elfinder/js/ui/searchbutton.js"></script>
					<script src="elfinder/js/ui/sortbutton.js"></script>
					<script src="elfinder/js/ui/panel.js"></script>
					<script src="elfinder/js/ui/contextmenu.js"></script>
					<script src="elfinder/js/ui/path.js"></script>
					<script src="elfinder/js/ui/stat.js"></script>
					<script src="elfinder/js/ui/places.js"></script>

					<!-- elfinder commands -->
					<script src="elfinder/js/commands/back.js"></script>
					<script src="elfinder/js/commands/forward.js"></script>
					<script src="elfinder/js/commands/reload.js"></script>
					<script src="elfinder/js/commands/up.js"></script>
					<script src="elfinder/js/commands/home.js"></script>
					<script src="elfinder/js/commands/copy.js"></script>
					<script src="elfinder/js/commands/cut.js"></script>
					<script src="elfinder/js/commands/paste.js"></script>
					<script src="elfinder/js/commands/open.js"></script>
					<script src="elfinder/js/commands/rm.js"></script>
					<script src="elfinder/js/commands/info.js"></script>
					<script src="elfinder/js/commands/duplicate.js"></script>
					<script src="elfinder/js/commands/rename.js"></script>
					<script src="elfinder/js/commands/help.js"></script>
					<script src="elfinder/js/commands/getfile.js"></script>
					<script src="elfinder/js/commands/mkdir.js"></script>
					<script src="elfinder/js/commands/mkfile.js"></script>
					<script src="elfinder/js/commands/upload.js"></script>
					<script src="elfinder/js/commands/download.js"></script>
					<script src="elfinder/js/commands/edit.js"></script>
					<script src="elfinder/js/commands/quicklook.js"></script>
					<script src="elfinder/js/commands/quicklook.plugins.js"></script>
					<script src="elfinder/js/commands/extract.js"></script>
					<script src="elfinder/js/commands/archive.js"></script>
					<script src="elfinder/js/commands/search.js"></script>
					<script src="elfinder/js/commands/view.js"></script>
					<script src="elfinder/js/commands/resize.js"></script>
					<script src="elfinder/js/commands/sort.js"></script>	
					<script src="elfinder/js/commands/netmount.js"></script>

					<script src="elfinder/js/jquery.dialogelfinder.js"></script>

					<!-- elfinder 1.x connector API support -->
					<script src="elfinder/js/proxy/elFinderSupportVer1.js"></script>
					'
				."\n");
		parent::render();
	}
}