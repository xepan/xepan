<?php
class page_owner_users extends page_base_owner {

	function init(){
		parent::init();
		$this->app->title="xEpan CMS" .': User Management';
		if(!$this->api->auth->model->isUserManagementAllowed())
			$this->api->redirect('owner/not-allowed');
	}

	function page_index(){
		$this->template->loadTemplate('page/owner/user');
		
		$usr=$this->add('Model_Users');
		$usr->addCondition('epan_id',$this->api->current_website->id);

		$usr->getElement('epan')->destroy();
		//Total Users
		$usr->addExpression('total_count')->set($usr->count());
		$usr->addExpression('total_active')->set($usr->newInstance()->addCondition('is_active',true)->count());
		$usr->addExpression('total_inactive')->set($usr->newInstance()->addCondition('is_active',false)->count());

		//Total Customers
		$usr->addExpression('total_customer')->set($usr->newInstance()->addcondition('type',50)->count());
		$usr->addExpression('total_active_customer')->set($usr->newInstance()->addcondition('type',50)->addCondition('is_active',true)->count());
		$usr->addExpression('total_inactive_customer')->set($usr->newInstance()->addcondition('type',50)->addCondition('is_active',false)->count());

		//Total Staff
		$usr->addExpression('total_staff')->set($usr->newInstance()->addcondition('type',80)->count());
		$usr->addExpression('total_active_staff')->set($usr->newInstance()->addcondition('type',80)->addCondition('is_active',true)->count());
		$usr->addExpression('total_inactive_staff')->set($usr->newInstance()->addcondition('type',80)->addCondition('is_active',false)->count());

		//Total Superuser
		$usr->addExpression('total_superuser')->set($usr->newInstance()->addcondition('type',100)->count());
		$usr->addExpression('total_active_superuser')->set($usr->newInstance()->addcondition('type',100)->addCondition('is_active',true)->count());
		$usr->addExpression('total_inactive_superuser')->set($usr->newInstance()->addcondition('type',100)->addCondition('is_active',false)->count());

		$usr->setOrder('last_login_date','desc');
		$usr->tryLoadAny();


		$this->template->set($usr->get());

		$crud=$this->add('CRUD_User',array('grid_class'=>'Grid_User','option_page'=>$this->api->url('./options'),'config_page'=>$this->api->url('./customfieldconfig'),'app_page'=>$this->api->url('./xyz')));
		$crud->setModel($usr,array('name','type','username','password','email','is_active','user_management','general_settings','application_management','website_designing','last_login_date'),array());

	}

	function page_xyz(){
		$container = $this->add('View');
        $container->addClass('atk-section atk-box atk-swatch-expander atk-padding-large atk-shapre-rounded');
        $col=$container->add('Columns');
        $col1=$col->addColumn(6);
		$this->api->stickyGET('users_id');
		$user = $this->add('Model_Users')->load($_GET['users_id']);

		$install_app = $this->add('Model_InstalledComponents');
		$grid = $col1->add('Grid');
		$grid->setModel($install_app,array('component'));
		
		$form = $col1->add('Form');
		$allowed_app = $form->addField('hidden','allowedapp')->set(json_encode($user->getAllowedApp()));
		$form->addSubmit('Update');


		$grid->addSelectable($allowed_app);

		if($form->isSubmitted()){
			$user->ref('UserAppAccess')->_dsql()->set('is_allowed',0)->update();
			$selected_apps = json_decode($form['allowedapp'],true);

			foreach ($selected_apps as $app_id) {
				$user->allowApp($app_id);
			}
			$form->js(null,$this->js()->univ()->closeDialog())->univ()->successMessage('Updated')->execute();
		}
	}

	function page_options(){
		$form = $this->add('Form');
		$form->addClass('stacked');
		$form->setModel($this->api->current_website,array('is_frontend_registration_allowed','user_activation','user_registration_email_subject','user_registration_email_message_body'));
		$form->addSubmit('Update');
		$form->add('Controller_FormBeautifier');
		if($form->isSubmitted()){
			$form->update();
			$form->js(null,$form->js()->univ()->successMessage('Options Updated'))->univ()->closeDialog()->execute();
		}
	}

	function page_emailconfig(){
		$form = $this->add('Form');
		$form->addClass('stacked');
		$form->setModel($this->api->current_website,array('user_registration_email_subject','user_registration_email_message_body'));
		$form->addSubmit('save');
		if($form->isSubmitted()){
			$form->update();
			$form->js(null,$form->js()->univ()->successMessage('Email Config Updated'))->univ()->closeDialog()->execute();
		}
	}

	function page_customfieldconfig(){
		$usercustomfield_model = $this->add('Model_UserCustomFields');
		$crud = $this->add('CRUD');
		$crud->setModel($usercustomfield_model);
		// $crud->add('Controller_FormBeautifier');
	}

	// function defaultTemplate(){
	// 	return ['page/owner/user'];
	// }
}
