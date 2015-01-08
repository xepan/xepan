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

		$user_model = $this->add('Model_User_FrontEnd');
		$this->api->auth->setModel($user_model,'username','password');
		$this->api->auth->addHook('updateForm',function($auth){
			$auth->form->addClass('stacked');
		});
		$this->api->auth->check();
		$this->api->current_website = $this->api->auth->model->ref('epan_id');
		$this->api->current_page = $this->api->current_website->ref('EpanPage');
		$this->api->memorize('website_requested',$this->api->current_website['name']);
		$this->api->load_plugins();
		
		$l=$this->app->add('Layout_Fluid');
		$this->app->top_menu =  $m=$this->app->layout->add('Menu_Horizontal',null,'Top_Menu');

        $admin_m = $m->addMenu('Admin');
        
        $admin_m->addItem(array('Dashboard','icon'=>'gauge-1'),'/owner/dashboard');
        $admin_m->addItem(array('User Management','icon'=>'users'),'/owner/users');
        $admin_m->addItem(array('General Settings','icon'=>'cog'),'/owner/epansettings');
        $admin_m->addItem(array('Application Repository','icon'=>'cog'),'/owner/applicationrepository');
        // $admin_m->addSeparator();
        $admin_m->addItem(array('Logout','icon'=>'logout'),'/logout');

		// Alert Notification 
		// Pages and Templates
		$web_designing_menu = $m->addMenu('WebSite');
		$web_designing_menu->addItem(array('Epan Pages','icon'=>'gauge-1'),'owner/epanpages');		
		$web_designing_menu->addItem(array('Epan Templates','icon'=>'gauge-1'),'owner/epantemplates');		
        

        $installed_components = $this->add('Model_InstalledComponents');
		$installed_components->addCondition('epan_id',$this->api->current_website->id);

		$components_m = $m->addMenu('Components');
		foreach ($installed_components as $comp) {
			$components_m->addItem(array($comp['name'],'icon'=>'right-hand'),$comp['namespace'].'_page_owner_dashboard');
		}
	}

	function recursiveRender(){
		// Add this usermanu at last to keep in last
		if(@$this->app->layout->user_menu){
			$menu=$this->app->layout->user_menu->addMenu(array($this->api->auth->model['name'],'icon'=>'user'));
		
		$alerts =$this->add('Model_Alerts');
		$badge=array();
		if($unread = $alerts->addCondition('is_read',false)->count()->getOne()){
			$badge=array('badge'=>array($unread,'swatch'=>'red'));
		}
		$menu->addItem(array_merge(array('Alert'),$badge),'/owner/alert');
		
		$msg_badge=array();
		$msg = $this->add('Model_Messages');
		$msg_unread=$msg->addCondition(
	        				$msg->_dsql()->orExpr()
	            					->where('is_read',false)
	            					->where('watch',true)
	   		 				)->count()->getOne();
		if($msg_unread){
			$msg_badge=array('badge'=>array($msg_unread,'swatch'=>'red'));
		}

		$menu->addItem(array_merge(array('Message'),$msg_badge),'/owner/message');
		$menu->addItem('Logout','logout');

		}
		parent::recursiveRender();
	}

	function render(){
		$this->api->template->appendHTML('js_include','<link type="text/css" href="elfinder/css/elfinder.min.css" rel="stylesheet" />'."\n");
			$this->api->template->appendHTML('js_include','<link type="text/css" href="elfinder/css/theme.css" rel="stylesheet" />'."\n");
			$this->api->template->appendHTML('js_include','<script src="elfinder/js/elfinder.full.js"></script>'."\n");
		parent::render();
	}

}