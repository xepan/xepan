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
		
		// if($this->app->isAjaxOutput() or $_GET['cut_page']){
		// 	$this->app->layout = $this;
		// 	return;
		// }

		$l=$this->app->add('Layout_Fluid'); // Usermanu is added in here
		$this->app->top_menu =  $m=$this->app->layout->add('Menu_Horizontal',null,'Top_Menu');

        $admin_m = $m->addMenu('Admin');
        
        $admin_m->addItem(array('Dashboard','icon'=>'gauge-1'),'/owner/dashboard');
        $admin_m->addItem(array('User Management','icon'=>'users'),'/owner/users');
        $admin_m->addItem(array('General Settings','icon'=>'cog'),'/owner/epansettings');
        $admin_m->addItem(array('Application Repository','icon'=>'cog'),'/owner/applicationrepository');
        $admin_m->addItem(array('Developer Zone','icon'=>'cog'),'developerZone_page_owner_dashboard');
        // $admin_m->addSeparator();
        $admin_m->addItem(array('Logout','icon'=>'logout'),'/logout');

		// Alert Notification 
		// Pages and Templates		
        
		$hr_m = $m->addMenu('HR');
		$hr_m->addItem(array('Dashboard','icon'=>'gauge-1'),'xHR_page_owner_dashboard');
		$hr_m->addItem(array('Departments','icon'=>'gauge-1'),'xHR_page_owner_department');
		$hr_m->addItem(array('Employees','icon'=>'gauge-1'),'xHR_page_owner_employees');
		$hr_m->addItem(array('Employees Attendence','icon'=>'gauge-1'),'xHR_page_owner_employeeattendence');
		$hr_m->addItem(array('Employees Leave','icon'=>'gauge-1'),'xHR_page_owner_employeeleave');
		$hr_m->addItem(array('Material Request','icon'=>'gauge-1'),'xStore_page_owner_materialrequest');
		
		$hr_m->addItem(array('Setup','icon'=>'cog'),'xHR_page_owner_setup');


		$marketing_m = $m->addMenu('Marketing');
		$marketing_m->addItem(array('Dashboard','icon'=>'gauge-1'),'xMarketingCampaign_page_owner_dashboard');
		$marketing_m->addItem(array('Manage Contacts','icon'=>'gauge-1'),'xMarketingCampaign_page_owner_emailcontacts');
		$marketing_m->addItem(array('Data Grabber','icon'=>'gauge-1'),'xMarketingCampaign_page_owner_mrkt_dtgrb_dtgrb');
		$marketing_m->addItem(array('Manage NewsLetters','icon'=>'gauge-1'),'xMarketingCampaign_page_owner_newsletters');
		$marketing_m->addItem(array('Add SocialContent','icon'=>'gauge-1'),'xMarketingCampaign_page_owner_socialcontents');
		$marketing_m->addItem(array('Campaigns','icon'=>'gauge-1'),'xMarketingCampaign_page_owner_campaigns');
		$marketing_m->addItem(array('Scheduled Jobs','icon'=>'gauge-1'),'xMarketingCampaign_page_owner_scheduledjobs');
		$marketing_m->addItem(array('Leads','icon'=>'gauge-1'),'xMarketingCampaign_page_owner_leads');
		$marketing_m->addItem(array('Configurations','icon'=>'gauge-1'),'xMarketingCampaign_page_owner_config');
		$marketing_m->addItem(array('Material Request','icon'=>'gauge-1'),'xStore_page_owner_materialrequest');

		$exec_m = $marketing_m->addMenu('Executors');
		$exec_m->addItem(array('Start Grabbing Data','icon'=>'gauge-1'),'xMarketingCampaign_page_owner_mrkt_dtgrb_exec');
		$exec_m->addItem(array('Start Sending Mass Email','icon'=>'gauge-1'),'xMarketingCampaign_page_emailexec');
		$exec_m->addItem(array('Update Social Activities','icon'=>'gauge-1'),'xMarketingCampaign_page_updatesocialactivityexec');
		$exec_m->addItem(array('Scheduled Emails from Campaign','icon'=>'gauge-1'),'xMarketingCampaign_page_owner_campaignexec');


		$sales_m = $m->addMenu('Sales');
		$sales_m->addItem(array('Dashboard','icon'=>'gauge-1'),'xShop_page_owner_dashboard');
		$sales_m->addItem(array('Oppertunity','icon'=>'gauge-1'),'xShop_page_owner_oppertunity');
		$sales_m->addItem(array('Quotation','icon'=>'gauge-1'),'xShop_page_owner_quotation');
		$sales_m->addItem(array('Shops & Blogs','icon'=>'gauge-1'),'xShop_page_owner_shopsnblogs');
		$sales_m->addItem(array('Category','icon'=>'gauge-1'),'xShop_page_owner_category');
		$sales_m->addItem(array('Item','icon'=>'gauge-1'),'xShop_page_owner_item');
		$sales_m->addItem(array('Affiliate','icon'=>'gauge-1'),'xShop_page_owner_afflilate');
		$sales_m->addItem(array('E-Voucher','icon'=>'gauge-1'),'xShop_page_owner_voucher');
		$sales_m->addItem(array('Member','icon'=>'gauge-1'),'xShop_page_owner_member');
		$sales_m->addItem(array('Order','icon'=>'gauge-1'),'xShop_page_owner_order');
		$sales_m->addItem(array('AddBlock','icon'=>'gauge-1'),'xShop_page_owner_addblock');
		$sales_m->addItem(array('Payment Gateway Config','icon'=>'gauge-1'),'xShop_page_owner_paygateconfig');
		$sales_m->addItem(array('Material Request','icon'=>'gauge-1'),'xStore_page_owner_materialrequest');
		
		$production_m = $m->addMenu('Production');
		$production_m->addItem(array('Dashboard','icon'=>'gauge-1'),'xProduction_page_owner_user_dashboard');
		$production_m->addItem(array('OutSource Party','icon'=>'gauge-1'),'xProduction_page_owner_outsourceparties');
		$production_depts = $this->add('xHR/Model_Department')
			->addCondition('is_production_department',true)
			->addCondition('is_system',false)
			;

		foreach($production_depts as $d){
			$production_m->addItem(array($d['name']. ' Job Status','icon'=>'gauge-1'),$this->api->url('xProduction_page_owner_dept_main',array('department_id'=>$d->id)));
			$production_m->addItem(array($d['name']. ' Material Request Notes','icon'=>'gauge-1'),$this->api->url('xProduction_page_owner_dept_main',array('department_id'=>$d->id)));
			$production_m->addItem(array($d['name']. ' Material Requests','icon'=>'gauge-1'),$this->api->url('xProduction_page_owner_dept_main',array('department_id'=>$d->id)));
		}

		$crm_m = $m->addMenu('CRM');
		$crm_m->addItem(array('Material Request','icon'=>'gauge-1'),'xStore_page_owner_materialrequest');
		


		$accounts_m = $m->addMenu('Accounts');
		$accounts_m->addItem(array('Material Request','icon'=>'gauge-1'),'xStore_page_owner_materialrequest');
		

		$purchase_m = $m->addMenu('Purchase');
		//$purchase_m->addItem(array('Dashboard','icon'=>'gauge-1'),'xPurchase_page_owner_dashboard');
		$purchase_m->addItem(array('Supplier','icon'=>'gauge-1'),'xPurchase_page_owner_supplier');
		$purchase_m->addItem(array('Purchase Material Request','icon'=>'gauge-1'),'xPurchase_page_owner_materialrequest');
		$purchase_m->addItem(array('Purchase Order','icon'=>'gauge-1'),'xPurchase_page_owner_purchaseorder');
		// $purchase_m->addItem(array('Supplier','icon'=>'gauge-1'),'xPurchase_page_owner_supplier');






		$store_m = $m->addMenu('Store');
		$store_m->addItem(array('Stock','icon'=>'gauge-1'),'xStore_page_owner_stock');
		$store_m->addItem(array('Material Request','icon'=>'gauge-1'),'xStore_page_owner_materialrequest');
		$store_m->addItem(array('Warehouse','icon'=>'gauge-1'),'xStore_page_owner_warehouse');
		
		




		// Add User Department secific Menus
		$employee = $this->add('xHR/Model_Employee')->loadFromLogin();
		
		if($employee->loaded()){
			$dept_namespace = $employee->department()->get('related_application_namespace');
			$dept_namespace;
			// if($dept_namespace){
				$my_menu = $m->addMenu('My',$dept_namespace.'/Menu_User');
				// if user ->post->can_create_teams
					$my_menu->addItem("Teams",'.');
					$my_menu->addItem("My Material Requirments",'xProduction_page_owner_materialrequirment');
			// }
		}

		// Setup current employee
		$this->app->current_employee = $this->add('xHR/Model_Employee');
		$this->app->current_employee->loadFromLogin();

        // $installed_components = $this->add('Model_InstalledComponents');
		// $installed_components->addCondition('epan_id',$this->api->current_website->id);

		// $components_m = $m->addMenu('Components');
		// foreach ($installed_components as $comp) {
		// 	$components_m->addItem(array($comp['name'],'icon'=>'right-hand'),$comp['namespace'].'_page_owner_dashboard');
		// }
	}

	function recursiveRender(){
		// Add this usermanu at last to keep in last
		$alerts =$this->add('Model_Alerts');
		$unread_alerts = $alerts->addCondition('is_read',false)->count()->getOne();
		$alert_badge=array();
		if($unread_alerts){
			$alert_badge=array('badge'=>array($unread_alerts,'swatch'=>'red'));
		}

		$msg = $this->add('Model_Messages');
		$unread_messages= $msg->addCondition(
	        				$msg->_dsql()->orExpr()
	            					->where('is_read',false)
	            					->where('watch',true)
	   		 				)->count()->getOne();
		$msg_badge=array();
		if($unread_messages){
			$msg_badge=array('badge'=>array($unread_messages,'swatch'=>'red'));
		}
		
		$admin_badge=null;
		if(($unread_alerts + $unread_messages) > 0){
			$admin_badge=array('badge'=>array($unread_alerts + $unread_messages ,'swatch'=>'red'));
			$admin_badge=$unread_alerts + $unread_messages;
		}

		if(@$this->app->layout->user_menu){

		$web_designing_menu = $this->app->layout->user_menu->addMenu('WebSite');
		$web_designing_menu->addItem(array('Epan Pages','icon'=>'gauge-1'),'owner/epanpages');		
		$web_designing_menu->addItem(array('Epan Templates','icon'=>'gauge-1'),'owner/epantemplates');		
		$web_designing_menu->addItem(array('Menus','icon'=>'right-hand'),'xMenus_page_owner_dashboard');
		$web_designing_menu->addItem(array('Enquiries & Subscriptions','icon'=>'right-hand'),'xEnquiryNSubscription_page_owner_dashboard');
		$web_designing_menu->addItem(array('Extended Elements','icon'=>'right-hand'),'ExtendedElement_page_owner_dashboard');
		$web_designing_menu->addItem(array('Slide Shows','icon'=>'right-hand'),'slideShows_page_owner_dashboard');
		$web_designing_menu->addItem(array('Extended Images','icon'=>'right-hand'),'extendedImages_page_owner_dashboard');
		$web_designing_menu->addItem(array('Image Gallaries','icon'=>'right-hand'),'xImageGallary_page_owner_dashboard');

			$menu=$this->app->layout->user_menu->addMenu(array($this->api->auth->model['name'] . '('.$this->api->current_employee->department()->get('name').'/'.$this->api->current_employee->post()->get('name').')','icon'=>'user'));
			$menu->addItem(array_merge(array('Alert'),$alert_badge),'/owner/alert');
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