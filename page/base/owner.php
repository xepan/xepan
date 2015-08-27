<?php
class page_base_owner extends Page {
	public $page_heading;
	public $page_subheading;
	public $menu;
	public $shortcut_menus=null;
	
	function init(){
		parent::init();
		$this->api->xpr->markPoint("ownermain init start");
		
		// Main BackEnd Authentication
		$user_model = $this->add('Model_User_BackEnd');
		$this->api->auth->setModel($user_model,'username','password');
		$this->api->auth->addHook('updateForm',function($auth){
			$auth->form->addClass('stacked');
		});
		$this->api->auth->check();
		
		$this->api->current_department = new Dummy();
		if($_GET['department_id']){
			$id = $this->api->stickyGET('department_id');
			$this->api->current_department = $this->add('xHR/Model_Department')->load($id);
		}

		if(!$this->api->auth->isLoggedIn()){
			$this->api->template->tryDel('admin_template');
		}

		$this->api->current_xshop_configuration = $this->add('xShop/Model_Configuration')->tryLoadAny();

		$this->app->current_employee = $this->add('xHR/Model_Employee');
		$this->app->current_employee->loadFromLogin();

		$this->app->top_menu =  $m = $this->app->layout->add('Menu_Horizontal',null,'Top_Menu');

		$this->api->xpr->markPoint("ownermain init done");
	}

	function recursiveRender(){
		$this->api->xpr->markPoint("ownermain rec-render start");
		
		$this->add('Controller_NotificationSystem')->setUpMain();

		$this->shorcut_menus = array();
		
		// Looks like you are called from update page
		if(isset($this->git_path)) return;

		if($this->app->isAjaxOutput() or $_GET['cut_page']){
			$this->api->xpr->markPoint("ownermain rec-render done by cut");
			return parent::recursiveRender();
		}

		$dept_model = $this->add('xHR/Model_Department');
		$m = $this->app->top_menu;

        $admin_m = $m->addMenu('Company');
        
        $admin_m->addItem(array('Dashboard','icon'=>'gauge-1'),'/owner/dashboard');
        $admin_m->addItem(array('User Management','icon'=>'users'),'/owner/users');
        $admin_m->addItem(array('Affiliate','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_afflilate'));
        $admin_m->addItem(array('General Settings','icon'=>'cog'),'/owner/epansettings');
        $admin_m->addItem(array('Documents','icon'=>'cog'),'/owner/documents');
        $admin_m->addItem(array('Application Repository','icon'=>'cog'),'/owner/applicationrepository');
        $admin_m->addItem(array('Developer Zone','icon'=>'cog'),'developerZone_page_owner_dashboard');
        // $admin_m->addSeparator();
        $admin_m->addItem(array('Logout','icon'=>'logout'),'/logout');
		
		$this->shorcut_menus[]=array("page"=>"Dashboard","url"=>$this->api->url("owner_dashboard"),"keys"=>'dashboard');
		$this->shorcut_menus[]=array("page"=>"Users","url"=>$this->api->url("owner_users"),'keys'=>'users logins');
		$this->shorcut_menus[]=array("page"=>"Affiliate","url"=>$this->api->url('xShop_page_owner_afflilate'));
		$this->shorcut_menus[]=array("page"=>"General Settings","url"=>$this->api->url("owner_epansettings"),'keys'=>'company settings general configurations');
		$this->shorcut_menus[]=array("page"=>"Generic Documents","url"=>$this->api->url("owner_documents"),'keys'=>'documents files scan private public shared');

		// Alert Notification 
		// Pages and Templates
		$installed_comps= $this->add('Model_InstalledComponents');
		$user_allowed_apps = $this->api->auth->model->getAllowedApp();

		// throw new \Exception(print_r($installed_comps->getCached(array('namespace'=>'xHR'),'id')));
		
		if(in_array($installed_comps->getCached(array('namespace'=>'xHR'),'id'),$user_allowed_apps)){
	        
			$hr_m = $m->addMenu(array('HR','bagde'=>12));
			$dept_model->id = $dept_model->getCached(array('name'=>'HR'),'id');

			$hr_m->addItem(array('Dashboard','icon'=>'gauge-1'),$this->api->url('xHR_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$hr_m->addItem(array('Departments','icon'=>'gauge-1'),$this->api->url('xHR_page_owner_department',array('department_id'=>$dept_model->id)));
			$hr_m->addItem(array('Employees','icon'=>'gauge-1'),$this->api->url('xHR_page_owner_employees',array('department_id'=>$dept_model->id)));
			// $hr_m->addItem(array('Employees Attendence','icon'=>'gauge-1'),$this->api->url('xHR_page_owner_employeeattendence',array('department_id'=>$dept_model->id)));
			// $hr_m->addItem(array('Employees Leave','icon'=>'gauge-1'),$this->api->url('xHR_page_owner_employeeleave',array('department_id'=>$dept_model->id)));
			// $hr_m->addItem(array('Material Request','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$hr_m->addItem(array('Stock Management','icon'=>'gauge-1'),$this->api->url('xHR_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));
			$hr_m->addItem(array('Setup','icon'=>'cog'),$this->api->url('xHR_page_owner_setup',array('department_id'=>$dept_model->id)));

			if($dept_model->officialEmails()->count()->getOne()){
				$hr_m->addItem(array('X Mail','icon'=>'gauge-1'),$this->api->url('xHR_page_owner_xmail',array('department_id'=>$dept_model->id)));
				$this->shorcut_menus[]=array("page"=>"HR X Mail","url"=>$this->api->url('xHR_page_owner_xmail',array('department_id'=>$dept_model->id)));
			}
			
			$this->shorcut_menus[]=array('keys'=>'hr dashboard mainpage summery',"page"=>"HR Dashboard","url"=>$this->api->url('xHR_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array('keys'=>'departments production phase posts salatery templates',"page"=>"Departments","url"=>$this->api->url('xHR_page_owner_department',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Employees","url"=>$this->api->url('xHR_page_owner_employees',array('department_id'=>$dept_model->id)));
			// $this->shorcut_menus[]=array("page"=>"Employees Attendence","url"=>$this->api->url('xHR_page_owner_employeeattendence',array('department_id'=>$dept_model->id)));
			// $this->shorcut_menus[]=array("page"=>"Employees Leave","url"=>$this->api->url('xHR_page_owner_employeeleave',array('department_id'=>$dept_model->id)));
			// $this->shorcut_menus[]=array("page"=>"HR Material Request","url"=>$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"HR Material Request Sent","url"=>$this->api->url('xStore_page_owner_materialrequestsent',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"HR Material Request Received","url"=>$this->api->url('xStore_page_owner_materialrequestreceived',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"HR Stock Management","url"=>$this->api->url('xHR_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));
		}


		if(in_array($installed_comps->getCached(array('namespace'=>'xMarketingCampaign'),'id'),$user_allowed_apps)){
			$marketing_m = $m->addMenu('Marketing');
			$dept_model->id = $dept_model->getCached(array('name'=>'Marketing'),'id');
			
			$marketing_m->addItem(array('Dashboard','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$marketing_m->addItem(array('Leads','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_leads',array('department_id'=>$dept_model->id)));
			$marketing_m->addItem(array('Manage NewsLetters','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_newsletters',array('department_id'=>$dept_model->id)));
			$marketing_m->addItem(array('Add SocialContent','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_socialcontents',array('department_id'=>$dept_model->id)));
			$marketing_m->addItem(array('Scheduled Jobs','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_scheduledjobs',array('department_id'=>$dept_model->id)));
			$marketing_m->addItem(array('Data Grabber','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_mrkt_dtgrb_dtgrb',array('department_id'=>$dept_model->id)));
			$marketing_m->addItem(array('Campaigns','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_campaigns',array('department_id'=>$dept_model->id)));
			$marketing_m->addItem(array('Contacts Summery','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_emailcontacts',array('department_id'=>$dept_model->id)));
			$marketing_m->addItem(array('Configurations','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_config',array('department_id'=>$dept_model->id)));
			$marketing_m->addItem(array('Material Request','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$marketing_m->addItem(array('Stock Management','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));

			if($dept_model->officialEmails()->count()->getOne()){
				$marketing_m->addItem(array('X Mail','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_xmail',array('department_id'=>$dept_model->id)));
				$this->shorcut_menus[]=array("page"=>"Marketing X Mail","url"=>$this->api->url('xMarketingCampaign_page_owner_xmail',array('department_id'=>$dept_model->id)));
			}

			$this->shorcut_menus[]=array("page"=>"Marketing Dashboard","url"=>$this->api->url('xMarketingCampaign_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Contacts Summery","url"=>$this->api->url('xMarketingCampaign_page_owner_emailcontacts',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Manage NewsLetters","url"=>$this->api->url('xMarketingCampaign_page_owner_newsletters',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Add SocialContent","url"=>$this->api->url('xMarketingCampaign_page_owner_socialcontents',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Scheduled Jobs","url"=>$this->api->url('xMarketingCampaign_page_owner_scheduledjobs',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Data Grabber","url"=>$this->api->url('xMarketingCampaign_page_owner_mrkt_dtgrb_dtgrb',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Campaigns","url"=>$this->api->url('xMarketingCampaign_page_owner_campaigns',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Leads Category","url"=>$this->api->url('xMarketingCampaign_page_owner_leadcategory',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Leads","url"=>$this->api->url('xMarketingCampaign_page_owner_leads',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Configurations","url"=>$this->api->url('xMarketingCampaign_page_owner_config',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Marketing Material Request","url"=>$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Marketing Material Request Sent","url"=>$this->api->url('xStore_page_owner_materialrequestsent',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Marketing Material Request Received","url"=>$this->api->url('xStore_page_owner_materialrequestreceived',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Marketing Stock Management","url"=>$this->api->url('xMarketingCampaign_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));


			$exec_m = $marketing_m->addMenu('Executors',null,array('SubMenu'));
			$exec_m->addItem(array('Start Grabbing Data','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_owner_mrkt_dtgrb_exec',array('department_id'=>$dept_model->id)));
			$exec_m->addItem(array('Start Sending Mass Email','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_emailexec',array('department_id'=>$dept_model->id)));
			$exec_m->addItem(array('Update Social Activities','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_updatesocialactivityexec',array('department_id'=>$dept_model->id)));
			$exec_m->addItem(array('Scheduled Emails from Campaign','icon'=>'gauge-1'),$this->api->url('xMarketingCampaign_page_campaignexec',array('department_id'=>$dept_model->id)));
		}


		if(in_array($installed_comps->getCached(array('namespace'=>'xShop'),'id'),$user_allowed_apps)){
			$sales_m = $m->addMenu('Sales');
			$dept_model->id = $dept_model->getCached(array('name'=>'Sales'),'id');


			$sales_m->addItem(array('Dashboard','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('Opportunity','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_opportunity',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('Quotation','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_quotation',array('department_id'=>$dept_model->id)));
			// $sales_m->addItem(array('Category','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_category',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('Item','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_item',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('E-Voucher','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_voucher',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('Customer','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_customer',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('Sales Order','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_order',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('Sales Invoice','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_invoice',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('AddBlock','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_addblock',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('Payment Gateway Config','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_paygateconfig',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('Material Request','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('Stock Management','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('Terms & Conditions','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_termsandcondition',array('department_id'=>$dept_model->id)));
			$sales_m->addItem(array('Configurations','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_shopsnblogs',array('department_id'=>$dept_model->id)));

			if($dept_model->officialEmails()->count()->getOne()){
				$sales_m->addItem(array('X Mail','icon'=>'gauge-1'),$this->api->url('xShop_page_owner_xmail',array('department_id'=>$dept_model->id)));
				$this->shorcut_menus[]=array("page"=>"Sales X Mail","url"=>$this->api->url('xShop_page_owner_xmail',array('department_id'=>$dept_model->id)));
			}
			
			$this->shorcut_menus[]=array('keys'=>'sales dashboard, mainpage department summery',"page"=>"Sales Dashboard","url"=>$this->api->url('xShop_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array('keys'=>'opportunity hot leads',"page"=>"Opportunity","url"=>$this->api->url('xShop_page_owner_opportunity',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Quotation","url"=>$this->api->url('xShop_page_owner_quotation',array('department_id'=>$dept_model->id)));
			// $this->shorcut_menus[]=array("page"=>"Category","url"=>$this->api->url('xShop_page_owner_category',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Item","url"=>$this->api->url('xShop_page_owner_item',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"E-Voucher","url"=>$this->api->url('xShop_page_owner_voucher',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Customer","url"=>$this->api->url('xShop_page_owner_customer',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Sales Orders","url"=>$this->api->url('xShop_page_owner_order',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"AddBlock","url"=>$this->api->url('xShop_page_owner_addblock',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Payment Gateway Config","url"=>$this->api->url('xShop_page_owner_paygateconfig',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Sales Material Request","url"=>$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Sales Material Request Sent","url"=>$this->api->url('xStore_page_owner_materialrequestsent',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Sales Material Request Received","url"=>$this->api->url('xStore_page_owner_materialrequestreceived',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Sales Stock Management","url"=>$this->api->url('xShop_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Terms and Conditions","url"=>$this->api->url('xShop_page_owner_termsandcondition',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Configurations","url"=>$this->api->url('xShop_page_owner_shopsnblogs',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Designer Fonts","url"=>$this->api->url('xShop_page_owner_font',array('department_id'=>$dept_model->id)));

		}

		

		if(in_array($installed_comps->getCached(array('namespace'=>'xProduction'),'id'),$user_allowed_apps)){
			$production_m = $m->addMenu('Production');

			$production_m->addItem(array('Dashboard','icon'=>'gauge-1'),$this->api->url('xProduction_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$production_m->addItem(array('OutSource Party','icon'=>'gauge-1'),$this->api->url('xProduction_page_owner_outsourceparties',array('department_id'=>$dept_model->id)));
			$production_depts = $this->add('xHR/Model_Department')
				->addCondition('is_production_department',true)
				->addCondition('is_system',false)
				;
			$this->shorcut_menus[]=array("page"=>'Outsource Parties',"url"=>$this->api->url('xProduction_page_owner_outsourceparties',array('department_id'=>$dept_model->id)));

			foreach($production_depts as $d){
				// if($d->id != $this->api->current_employee->department()->get('id')) continue;
				$production_menu = $production_m->addMenu($d['name']);

				$production_menu->addItem(array(' Job Status','icon'=>'gauge-1'),$this->api->url('xProduction_page_owner_dept_main',array('department_id'=>$d->id)));
				$production_menu->addItem(array(' Material Requests','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$d->id)));
				$production_menu->addItem(array(' Stock Management','icon'=>'gauge-1'),$this->api->url('xProduction_page_owner_stockmanagement',array('department_id'=>$d->id)));
				$this->shorcut_menus[]=array("page"=>$d['name']. ' Job Status',"url"=>$this->api->url('xProduction_page_owner_dept_main',array('department_id'=>$d->id)));
				$this->shorcut_menus[]=array("page"=>$d['name']. ' Material Requests',"url"=>$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$d->id)));
				
				if($d->officialEmails()->count()->getOne()){
					$production_menu->addItem(array(' X Mail','icon'=>'gauge-1'),$this->api->url('xProduction_page_owner_xmail',array('department_id'=>$d->id)));
					$this->shorcut_menus[]=array("page"=>$d['name']. ' X Mail',"url"=>$this->api->url('xProduction_page_owner_xmail',array('department_id'=>$d->id)));
				}
				$this->shorcut_menus[]=array("page"=>$d['name']. " Material Request Sent","url"=>$this->api->url('xStore_page_owner_materialrequestsent',array('department_id'=>$d->id)));
				$this->shorcut_menus[]=array("page"=>$d['name']. " Material Request Received","url"=>$this->api->url('xStore_page_owner_materialrequestreceived',array('department_id'=>$d->id)));
				$this->shorcut_menus[]=array("page"=>$d['name']. " Stock Management","url"=>$this->api->url('xProduction_page_owner_stockmanagement',array('department_id'=>$d->id)));
			}
		}

			
		if(in_array($installed_comps->getCached(array('namespace'=>'xCRM'),'id'),$user_allowed_apps)){
			
			$crm_m = $m->addMenu('CRM');
			$dept_model->id = $dept_model->getCached(array('name'=>'CRM'),'id');

			$crm_m->addItem(array('Dashboard','icon'=>'gauge-1'),$this->api->url('xCRM_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$crm_m->addItem(array('Support Tickets','icon'=>'gauge-1'),$this->api->url('xCRM_page_owner_ticket',array('department_id'=>$dept_model->id)));
			// $crm_m->addItem(array('Company Emails','icon'=>'gauge-1'),$this->api->url('xCRM_page_owner_dashboard',array('department_id'=>$dept_model->id)));


			$crm_m->addItem(array('Material Request','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$crm_m->addItem(array('Stock Management','icon'=>'gauge-1'),$this->api->url('xCRM_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));
			
			if($dept_model->officialEmails()->count()->getOne()){				
				$crm_m->addItem(array('X Mail','icon'=>'gauge-1'),$this->api->url('xCRM_page_owner_xmail',array('department_id'=>$dept_model->id)));
				$this->shorcut_menus[]=array("page"=>"CRM X Mail","url"=>$this->api->url('xCRM_page_owner_xmail',array('department_id'=>$dept_model->id)));
			}

			$this->shorcut_menus[]=array("page"=>"CRM Dashboard","url"=>$this->api->url('xCRM_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"CRM Material Request","url"=>$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"CRM Material Request Sent","url"=>$this->api->url('xStore_page_owner_materialrequestsent',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"CRM Material Request Received","url"=>$this->api->url('xStore_page_owner_materialrequestreceived',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"CRM Stock Management","url"=>$this->api->url('xCRM_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));
		}
		
		if(in_array($installed_comps->getCached(array('namespace'=>'xAccount'),'id'),$user_allowed_apps)){
			$accounts_m = $m->addMenu('Accounts');
			$dept_model->id = $dept_model->getCached(array('name'=>'Accounts'),'id');

			$accounts_m->addItem(array('Dashboard','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			// $accounts_m->addItem(array('Balance Sheet','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_balancesheet',array('department_id'=>$dept_model->id)));
			// $accounts_m->addItem(array('Group','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_group',array('department_id'=>$dept_model->id)));
			$accounts_m->addItem(array('Payment Paid','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_amtpaid',array('department_id'=>$dept_model->id)));
			$accounts_m->addItem(array('Payment Received','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_amtreceived',array('department_id'=>$dept_model->id)));
			$accounts_m->addItem(array('Cash & Bank','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_contra',array('department_id'=>$dept_model->id)));
			$accounts_m->addItem(array('Account Statement','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_acstatement',array('department_id'=>$dept_model->id)));
			$accounts_m->addItem(array('Cash Book','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_cashbook',array('department_id'=>$dept_model->id)));
			$accounts_m->addItem(array('Day Book','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_daybook',array('department_id'=>$dept_model->id)));
			$accounts_m->addItem(array('Ledgers','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_ledgers',array('department_id'=>$dept_model->id)));
			$accounts_m->addItem(array('Debit/Credit Note','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_debitcreditnote',array('department_id'=>$dept_model->id)));
			$accounts_m->addItem(array('Material Request','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$accounts_m->addItem(array('Stock Management','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));

			if($dept_model->officialEmails()->count()->getOne()){
				$accounts_m->addItem(array('X Mail','icon'=>'gauge-1'),$this->api->url('xAccount_page_owner_xmail',array('department_id'=>$dept_model->id)));
				$this->shorcut_menus[]=array("page"=>"Accounts X Mail","url"=>$this->api->url('xAccount_page_owner_xmail',array('department_id'=>$dept_model->id)));
			}
			
			$this->shorcut_menus[]=array("page"=>"Accounts Dashboard","url"=>$this->api->url('xAccounts_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Payment Paid","url"=>$this->api->url('xAccount_page_owner_amtpaid',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Payment Received","url"=>$this->api->url('xAccount_page_owner_amtreceived',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array('keys'=>'Cash bank and withdraw deposit',"page"=>"Cash And Bank","url"=>$this->api->url('xAccount_page_owner_contra',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Account Statement","url"=>$this->api->url('xAccount_page_owner_acstatement',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Cash Book","url"=>$this->api->url('xAccount_page_owner_cashbook',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Day Book","url"=>$this->api->url('xAccount_page_owner_daybook',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Ledgers","url"=>$this->api->url('xAccount_page_owner_ledgers',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Accounts Material Request","url"=>$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Accounts Material Request Sent","url"=>$this->api->url('xStore_page_owner_materialrequestsent',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Accounts Material Request Received","url"=>$this->api->url('xStore_page_owner_materialrequestreceived',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Accounts Stock Management","url"=>$this->api->url('xAccount_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Account Debit/Credit Note","url"=>$this->api->url('xAccount_page_owner_debitcreditnote',array('department_id'=>$dept_model->id)));
		}
		

		// throw new \Exception(print_r($installed_comps->getCached(array('namespace'=>'xPurchase'),'id')));
		
		if(in_array($installed_comps->getCached(array('namespace'=>'xPurchase'),'id'),$user_allowed_apps)){
			$purchase_m = $m->addMenu('Purchase');
			$dept_model->id = $dept_model->getCached(array('name'=>'Purchase'),'id');

			$purchase_m->addItem(array('Dashboard','icon'=>'gauge-1'),$this->api->url('xPurchase_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$purchase_m->addItem(array('Supplier','icon'=>'gauge-1'),$this->api->url('xPurchase_page_owner_supplier',array('department_id'=>$dept_model->id)));
			$purchase_m->addItem(array('Material Request','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$purchase_m->addItem(array('Purchase Order','icon'=>'gauge-1'),$this->api->url('xPurchase_page_owner_purchaseorder',array('department_id'=>$dept_model->id)));
			$purchase_m->addItem(array('Purchase Invoice','icon'=>'gauge-1'),$this->api->url('xPurchase_page_owner_purchaseinvoice',array('department_id'=>$dept_model->id)));
			$purchase_m->addItem(array('Stock Management','icon'=>'gauge-1'),$this->api->url('xPurchase_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));
			// $purchase_m->addItem(array('Supplier','icon'=>'gauge-1'),'xPurchase_page_owner_supplier');
			if($dept_model->officialEmails()->count()->getOne()){
				$purchase_m->addItem(array('X Mail','icon'=>'gauge-1'),$this->api->url('xPurchase_page_owner_xmail',array('department_id'=>$dept_model->id)));
				$this->shorcut_menus[]=array("page"=>"Purchase X Mail","url"=>$this->api->url('xPurchase_page_owner_xmail',array('department_id'=>$dept_model->id)));
			}

			$this->shorcut_menus[]=array("page"=>"Purchase Dashboard","url"=>$this->api->url('xPurchase_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Supplier","url"=>$this->api->url('xPurchase_page_owner_supplier',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Purchase Material Request","url"=>$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Purchase Material Request Sent","url"=>$this->api->url('xStore_page_owner_materialrequestsent',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Purchase Material Request Received","url"=>$this->api->url('xStore_page_owner_materialrequestreceived',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Purchase Order","url"=>$this->api->url('xPurchase_page_owner_purchaseorder',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Purchase Stock Management","url"=>$this->api->url('xPurchase_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));
		}	


		if(in_array($installed_comps->getCached(array('namespace'=>'xStore'),'id'),$user_allowed_apps)){
			$store_m = $m->addMenu('Store');
			$dept_model->id = $dept_model->getCached(array('name'=>'Store'),'id');

			$store_m->addItem(array('Dashboard','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$store_m->addItem(array('Stock','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_stock',array('department_id'=>$dept_model->id)));
			$store_m->addItem(array('Warehouse','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_warehouse',array('department_id'=>$dept_model->id)));
			$store_m->addItem(array('Material Request','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$store_m->addItem(array('Stock Management','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));
			
			if($dept_model->officialEmails()->count()->getOne()){
				$store_m->addItem(array('X Mail','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_xmail',array('department_id'=>$dept_model->id)));
				$this->shorcut_menus[]=array("page"=>"Store X Mail","url"=>$this->api->url('xStore_page_owner_xmail',array('department_id'=>$dept_model->id)));
			}
			
			$this->shorcut_menus[]=array("page"=>"Store Dashboard","url"=>$this->api->url('xStore_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Stock","url"=>$this->api->url('xStore_page_owner_stock',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Store Material Request","url"=>$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Store Material Request Sent","url"=>$this->api->url('xStore_page_owner_materialrequestsent',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Store Material Request Received","url"=>$this->api->url('xStore_page_owner_materialrequestreceived',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Stock Management","url"=>$this->api->url('xStore_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));

			$this->shorcut_menus[]=array("page"=>"Warehouse","url"=>$this->api->url('xStore_page_owner_warehouse',array('department_id'=>$dept_model->id)));
		}	


		if(in_array($installed_comps->getCached(array('namespace'=>'xDispatch'),'id'),$user_allowed_apps)){
			$dispatch_m = $m->addMenu('Dispatch');
			$dept_model->id = $dept_model->getCached(array('name'=>'Dispatch And Delivery'),'id');

			$dispatch_m->addItem(array('Dashboard','icon'=>'gauge-1'),$this->api->url('xDispatch_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$dispatch_m->addItem(array('Dispatch Requests','icon'=>'gauge-1'),$this->api->url('xDispatch_page_owner_dispatchrequest',array('department_id'=>$dept_model->id)));
			$dispatch_m->addItem(array('Material Request','icon'=>'gauge-1'),$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$dispatch_m->addItem(array('Delivery Note','icon'=>'gauge-1'),$this->api->url('xDispatch_page_owner_deliverynote',array('department_id'=>$dept_model->id)));
			$dispatch_m->addItem(array('Stock Management','icon'=>'gauge-1'),$this->api->url('xDispatch_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));

			if($dept_model->officialEmails()->count()->getOne()){
				$dispatch_m->addItem(array('X Mail','icon'=>'gauge-1'),$this->api->url('xDispatch_page_owner_xmail',array('department_id'=>$dept_model->id)));
				$this->shorcut_menus[]=array("page"=>"Dispatch X Mail","url"=>$this->api->url('xDispatch_page_owner_xmail',array('department_id'=>$dept_model->id)));
			}
			
			$this->shorcut_menus[]=array("page"=>"Dispatch Dashboard","url"=>$this->api->url('xDispatch_page_owner_dashboard',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Dispatch Requests","url"=>$this->api->url('xDispatch_page_owner_dispatchrequest',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Delivery Note","url"=>$this->api->url('xDispatch_page_owner_deliverynote',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Dispatch Material Request","url"=>$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Dispatch Material Request Sent","url"=>$this->api->url('xStore_page_owner_materialrequestsent',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Dispatch Material Request Received","url"=>$this->api->url('xStore_page_owner_materialrequestreceived',array('department_id'=>$dept_model->id)));
			$this->shorcut_menus[]=array("page"=>"Dispatch Stock Management","url"=>$this->api->url('xDispatch_page_owner_stockmanagement',array('department_id'=>$dept_model->id)));
		}	

		// 		in_array($installed_comps->getCached(array('namespace'=>'xHR'),'id'),$user_allowed_apps)
		// $dept_model->id = $dept_model->getCached(array('name'=>'HR'),'id');
		// Add User Department secific Menus
			
		$this->api->xpr->markPoint("All Menus Set");
		if($this->api->current_employee->loaded()){
			$dept_namespace = $this->api->current_employee->department()->get('related_application_namespace');
			// if($dept_namespace){

				$task = $this->add('xProduction/Model_Task');
				$unread_task= $task->addCondition(
			        				$task->_dsql()->orExpr()
			            					->where(
			            							$task->dsql()->andExpr()
				            							->where('employee_id',$this->api->current_employee->id)
						            					->where('status','assigned')
						            		)
						            		->where(
			            							$task->dsql()->andExpr()
				            							->where('created_by_id',$this->api->current_employee->id)
						            					->where('status','draft')
						            		)
			   		 				)->count()->getOne();

				$processing_task=$task->newInstance()->addCondition(
			        				$task->_dsql()->orExpr()
	            							->where('employee_id',$this->api->current_employee->id)
	            							->where('created_by_id',$this->api->current_employee->id)
						            		)
									->addCondition('status','processing')
			   		 				->count()->getOne();

					$task_badge=$unread_task + $processing_task;

				$my_menu = $m->addMenu(array('My'. "   ",'badge'=>array($unread_task." / ".$task_badge,'swatch'=>'red'),'icon'=>'gauge-1'),$dept_namespace.'/Menu_User');
				// if user ->post->can_create_teams
					// $my_menu->addItem("Teams",$this->api->url('xProduction_page_owner_teammanager',array('department_id'=>$this->api->current_employee['department_id'])));
					$my_menu->addItem("My Material Requests",$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$this->api->current_employee['department_id'])));
					$my_menu->addItem("Accounts Settings",$this->api->url('xProduction_page_owner_user_accountinfo',array('department_id'=>$this->api->current_employee['department_id'])));
					
					$my_menu->addItem("X Mail",$this->api->url('xHR_page_owner_xmail',array('department_id'=>$this->api->current_employee['department_id'])));
					
					$this->shorcut_menus[]=array("page"=>"My Tasks","url"=>$this->api->url('xProduction_page_owner_user_tasks',array('department_id'=>$dept_model->id)));
					$this->shorcut_menus[]=array("page"=>"X Mail","url"=>$this->api->url('xHR_page_owner_xmail',array('department_id'=>$dept_model->id)));
					$this->shorcut_menus[]=array("page"=>"My Material Request","url"=>$this->api->url('xStore_page_owner_materialrequest',array('department_id'=>$dept_model->id)));
					$this->shorcut_menus[]=array("page"=>"My Material Request Sent","url"=>$this->api->url('xStore_page_owner_materialrequestsent',array('department_id'=>$dept_model->id)));
					$this->shorcut_menus[]=array("page"=>"My Material Request Received","url"=>$this->api->url('xStore_page_owner_materialrequestreceived',array('department_id'=>$dept_model->id)));
			// }
		
		}
		$this->api->xpr->markPoint("My Tasks done now alerts");

		// ============ USER MENUS =================
		
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

		$web_designing_menu = $m->addMenu('WebSite');
		$web_designing_menu->addItem(array('Epan Pages','icon'=>'gauge-1'),'owner/epanpages');		
		$web_designing_menu->addItem(array('Epan Templates','icon'=>'gauge-1'),'owner/epantemplates');		
		$web_designing_menu->addItem(array('Menus','icon'=>'right-hand'),'xMenus_page_owner_dashboard');
		$web_designing_menu->addItem(array('Enquiries & Subscriptions','icon'=>'right-hand'),'xEnquiryNSubscription_page_owner_dashboard');
		$web_designing_menu->addItem(array('Extended Elements','icon'=>'right-hand'),'ExtendedElement_page_owner_dashboard');
		$web_designing_menu->addItem(array('Slide Shows','icon'=>'right-hand'),'slideShows_page_owner_dashboard');
		$web_designing_menu->addItem(array('Extended Images','icon'=>'right-hand'),'extendedImages_page_owner_dashboard');
		$web_designing_menu->addItem(array('Image Gallaries','icon'=>'right-hand'),'xImageGallery_page_owner_dashboard');
		// $web_designing_menu->addItem(array('Blog','icon'=>'right-hand'),'xShop_page_owner_blog');
		$web_designing_menu->addItem(array('Blog','icon'=>'right-hand'),'xBlog_page__owner_dashboard');
		
		$this->app->layout->add('View',null,'UserMenu')
			->setHTML($this->api->auth->model['name'] . '<br/><span class="atk-text-dimmed atk-size-micro">('.$this->api->current_employee->department()->get('name').'/'.$this->api->current_employee->post()->get('name').')</span>');
		
		if($this->app->layout->user_menu){
			// $menu=$this->app->layout->user_menu->addMenu(array($this->api->auth->model['name'] . '('.$this->api->current_employee->department()->get('name').'/'.$this->api->current_employee->post()->get('name').')','icon'=>'user'));
			// $menu->addItem(array_merge(array('Alert'),$alert_badge),'/owner/alert');
			// $menu->addItem(array_merge(array('Message'),$msg_badge),'/owner/message');
			// $menu->addItem('Logout','logout');
			$this->app->layout->user_menu->destroy();
		}

		$menu=array($this->api->top_menu);
		$this->api->event('menu-created',$menu);
		if($_GET['xnotifier'] or !$_GET['cut_page']){
			// $this->add('View_Notification',array('update_seen_till'=>$_GET['see']));
		}

		if($this->app->layout->template->get('page_title')[0] == 'Page Title') $this->app->layout->template->del('page_title');

		$this->api->xpr->markPoint("ownermain (page only) rec-render done : Now components render time");
		parent::recursiveRender();
	}

	function render(){
		$this->api->template->appendHTML('js_include','<link type="text/css" href="elfinder/css/elfinder.min.css" rel="stylesheet" />'."\n");
		$this->api->template->appendHTML('js_include','<link type="text/css" href="elfinder/css/theme.css" rel="stylesheet" />'."\n");
		$this->api->template->appendHTML('js_include','<script src="elfinder/js/elfinder.full.js"></script>'."\n");
		$this->api->template->appendHTML('js_include','<script src="templates/js/shortcut.js"></script>'."\n");
		
		$this->api->js(true)->_load('utilities/fuse.min')->_load('utilities/shortmenus')->univ()->setUpShortMenus($this->shorcut_menus, $this->api->url());

		parent::render();
	}

}