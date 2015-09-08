<?php

class Model_Users extends Model_Table {
	var $table= "users";

	function init(){
		parent::init();
		
		$this->hasOne('Epan','epan_id')->mandatory(true);
		$this->addCondition('epan_id',$this->api->current_website->id);

		$f=$this->addField('name')->group('a~6~<i class="fa fa-user"></i> User Info')->mandatory(true)->sortable(true);
		$f->icon='fa fa-user~red';

		$f=$this->addField('type')->setValueList(array(100=>'SuperUser',80=>'BackEndUser',50=>'FrontEndUser'))->defaultValue(50)->group('a~6')->sortable(true)->mandatory(false);
		$f->icon="fa fa-question~red";
		$f=$this->addField('username')->group('b~6~<i class="fa fa-lock"></i> Login Credentials')->mandatory(true)->sortable(true);
		$f->icon="fa fa-lock~red";

		$f=$this->addField('password')->type('password')->group('b~6')->mandatory(true);
		$f->icon="fa fa-key~red";
		$f=$this->addField('email')->mandatory(true)->sortable(true);
		$f->icon = "fa fa-envelope~red";
		$f=$this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'))->display(array('form'=>'Readonly'))->group('c~6')->sortable(true);
		$f->icon='fa fa-calendar~blue';
		// $this->addField('is_systemuser')->type('boolean')->defaultValue(false);
		// $this->addField('is_frontenduser')->type('boolean')->defaultValue(false);
		// $this->addField('is_backenduser')->type('boolean')->defaultValue(false);
		$f = $this->addField('is_active')->type('boolean')->defaultValue(true)->group('c~6')->sortable(true);
		$f->icon = "fa fa-exclamation~blue";

		$f = $this->addField('user_management')->type('boolean')->defaultValue(false)->group('c~6');
		$f = $this->addField('general_settings')->type('boolean')->defaultValue(false)->group('c~6');
		$f = $this->addField('application_management')->type('boolean')->defaultValue(false)->group('c~6');
		$f = $this->addField('website_designing')->type('boolean')->defaultValue(false)->group('c~6');

		$f=$this->addField('activation_code')->group('d~3')->display(array('form'=>'Readonly'))->sortable(true);
		$f->icon = 'fa fa-unlock-alt~blue';
		$f=$this->addField('last_login_date')->type('datetime')->group('d~9')->display(array('form'=>'Readonly'))->sortable(true);
		$f->icon='fa fa-calendar~blue';

		$this->hasMany('UserAppAccess','user_id');
		$this->hasMany('xHR/Employee','user_id');

		// $this->add('Controller_Validator');
		// $this->is(array(
		// 					'name|to_trim|required?type User name here',
		// 					'email|email',
		// 					'username|to_trim|unique'
		// 				)
		// 		);

		$this->addHook('beforeDelete',$this);
		$this->addHook('beforeSave',$this);
		$this->addHook('afterInsert',$this);
		$this->addHook('afterLoad',$this);
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function afterLoad(){
		if(!$this['username']) $this['username'] = 'user_'. $this->id;
		if(!$this['password']) $this['password'] = 'pass_'. rand(100000,999999);
	}

	function afterInsert($obj,$new_id){		
		$user_model=$this->add('Model_Users')->load($new_id);
		if(isset($this->allow_re_adding_user))
			$user_model->allow_re_adding_user = $this->allow_re_adding_user;
		
		$user_model_value = array($user_model);
		$this->api->event('new_user_registered',$user_model_value);
	}

	function isEmailExist($email){
		if(!$email)
			return false;

		$user = $this->add('Model_Users');
		$user->addCondition('email',$email);
		$user->tryLoadAny();
		return $user->count()->getOne();
	}

	function beforeSave(){
		
		//Check User Name is Empty
		if($this->dirty['type'] and $this['type'] == ""){
			throw $this->exception('User Type Must be Defined','ValidityCheck')->setField('type');
		}
		
		// Check username for THIS EPAN
		$old_user = $this->add('Model_Users');
		$old_user->addCondition('username',$this['username']);
		
		if(isset($this->api->current_website))
			$old_user->addCondition('epan_id',$this->api->current_website->id);
		if($this->loaded()){
			$old_user->addCondition('id','<>',$this->id);
		}
		$old_user->tryLoadAny();
		if($old_user->loaded()){
			throw $this->exception('This username(Email) is already taken, Chose Another','Growl')->setField('email');
		}

		if(!isset($this->allow_duplicate_email)){
			// Check username for THIS EPAN
			$old_email = $this->add('Model_Users');
			$old_email->addCondition('email',$this['email']);
			
			if(isset($this->api->current_website))
				$old_user->addCondition('epan_id',$this->api->current_website->id);
			if($this->loaded()){
				$old_email->addCondition('id','<>',$this->id);
			}
			$old_email->tryLoadAny();
			if($old_email->loaded()){
				// throw $this->exception("This username is allready taken, Chose Another");
				$this->api->js()->univ()->errorMessage('This Email is already taken, Chose Another')->execute();
			}
		}

		if($this->isFrontEndUser()){
			$this['user_management']=false;
			$this['general_settings']=false;
			$this['application_management']=false;
			$this['website_designing']=false;

			if($this->loaded())
				$this->ref('UserAppAccess')->addCondition('is_allowed',true)->deleteAll();
		}
	}

	function beforeDelete(){
		if(!isset($this->force_delete) AND $this['username'] == $this->ref('epan_id')->get('name')) // Userd for multisite epan
			throw $this->exception("You Can't delete it, it is default username");

		$this->ref('UserAppAccess')->each(function($uapacc){
			$uapacc->delete();
		});
		
		$this->api->event('user_before_delete',$this);
	}

	function forceDelete(){
		$this->force_delete = true;
		$member= $this->add('xShop/Model_MemberDetails')->addCondition('users_id',$this->id)->tryLoadAny();
		if($member->loaded()) $member->forceDelete();

		$this->ref('UserAppAccess')->each(function($obj){
			$obj->forceDelete();
		});

		$this->add('xHR/Model_Employee')
			->addCondition('user_id',$this->id)
			->each(function($obj){
				$obj->set('user_id',NULL)->saveAndUnload();
			});

		$this->delete();

	}

	function validateUser(){

	}

	function updatePassword($new_password){
		if(!$this->loaded()) return false;
			$this['password']=$new_password;
			$this->save();
			return $this;
	}	


	//Send Password Update Successfully Email
	function sendPasswordUpdateMail($email_id=null){
		if(!$this->loaded()) return false;

		$user = $this;
		if($email_id){
			$user = $this->add('Model_Users')->addCondition('email',$email_id);	
			$user->tryLoadAny();
		}

		$tm=$this->add( 'TMail_Transport_PHPMailer' );

		$subject =$this->api->current_website['password_forget_email_subject'];
		$email_body=$this->api->current_website['password_forget_email_body'];
		$email_body=str_replace("{{name}}", $user['name'], $email_body);
		$email_body=str_replace("{{email}}", $user['email'], $email_body);
		$email_body=str_replace("{{user_name}}", $user['username'], $email_body);
		// $email_body=str_replace("{{password}}", "******", $email_body);
		$email_body=str_replace("{{activation_code}}", $user['activation_code'], $email_body);
			
			$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
		$host     = $_SERVER['HTTP_HOST'];
		$script   = $_SERVER['SCRIPT_NAME'];
		$params   = $_SERVER['QUERY_STRING'];
		$currentUrl = $protocol. '://' .$host;
				
		$email_body=str_replace("{{click_here_to_activate}}",
										"<a href=\"".$currentUrl.str_replace("&new_registration=1","", $this->api->url(null,array(
												'activation_code'=>$user['activation_code'],
												'activate_email'=>$user['email'],
												'user_selected_form'=>"login"
											)))."\">Click Here </a>",$email_body);
		

		try{
			$tm->send( $user['email'], $this->api->current_website['email_username'], $subject, $email_body ,false,null);
		}catch( phpmailerException $e ) {
			$this->api->js()->univ()->errorMessage( $e->errorMessage() . " "  )->execute();
		}catch( Exception $e ) {
			throw $e;
		}

	}


	//Send Password Verification Email With Activation Code
	function sendPasswordVerificationMail($email_id=null){
		if(!$this->loaded()) return false;

		$user = $this;
		if($email_id){
			$user = $this->add('Model_Users')->addCondition('email',$email_id);	
			$user->tryLoadAny();
		}


		$tm=$this->add( 'TMail_Transport_PHPMailer' );

		$subject =$this->api->current_website['password_forget_email_subject'];
		$email_body=$this->api->current_website['password_forget_email_body'];
		$email_body=str_replace("{{name}}", $user['name'], $email_body);
		$email_body=str_replace("{{email}}", $user['email'], $email_body);
		$email_body=str_replace("{{user_name}}", $user['username'], $email_body);
		// $email_body=str_replace("{{password}}", "******", $email_body);
		$email_body=str_replace("{{activation_code}}", $user['activation_code'], $email_body);
			
			$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
		$host     = $_SERVER['HTTP_HOST'];
		$script   = $_SERVER['SCRIPT_NAME'];
		$params   = $_SERVER['QUERY_STRING'];
		$currentUrl = $protocol. '://' .$host;
				
		$email_body=str_replace("{{click_here_to_activate}}",
										"<a href=\"".$currentUrl.str_replace("&new_registration=1","", $this->api->url(null,array(
												'activation_code'=>$user['activation_code'],
												'activate_email'=>$user['email'],
												'user_selected_form'=>"forget_password",
												'update_password'=>"true"
											)))."\">Click Here </a>",$email_body);
		

		try{
			$tm->send( $user['email'], $this->api->current_website['email_username'], $subject, $email_body ,false,null);
		}catch( phpmailerException $e ) {
			$this->api->js()->univ()->errorMessage( $e->errorMessage() . " "  )->execute();
		}catch( Exception $e ) {
			throw $e;
		}

	}

	function sendVerificationMail($email=null,$type=null,$activation_code=null){
		
		if(!$this->loaded()){
			$this->addCondition('email',$email);
			$this->tryLoadAny();
		}	

		// $this['email'] = $email;
		// $this['activation_code'] = $activation_code;
		// $this->save();
		// $type = null;
			$tm=$this->add( 'TMail_Transport_PHPMailer' );

			$subject =$this->api->current_website['user_registration_email_subject'];
			$email_body=$this->api->current_website['user_registration_email_message_body'];
			$email_body=str_replace("{{name}}", $this['name'], $email_body);
			$email_body=str_replace("{{email}}", $this['email'], $email_body);
			$email_body=str_replace("{{user_name}}", $this['username'], $email_body);
			// $email_body=str_replace("{{password}}", "******", $email_body);
			$email_body=str_replace("{{activation_code}}", $this['activation_code'], $email_body);
 			
 			$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
			$host     = $_SERVER['HTTP_HOST'];
			$script   = $_SERVER['SCRIPT_NAME'];
			$params   = $_SERVER['QUERY_STRING'];
			$currentUrl = $protocol. '://' .$host;
			
			
			$email_body=str_replace("{{click_here_to_activate}}",
											"<a href=\"".$currentUrl.str_replace("&new_registration=1","", $this->api->url(null,array(
													'activation_code'=>$this['activation_code'],
													'activate_email'=>$this['email'],
													'user_selected_form'=>"verify_account"
												)))."\">Click Here to Activate Your Account</a>",$email_body);
						
			try{
				$tm->send( $this['email'], $this->api->current_website['email_username'], $subject, $email_body ,false,null);
			}catch( phpmailerException $e ) {
				$this->api->js()->univ()->errorMessage( $e->errorMessage() . " "  )->execute();
			}catch( Exception $e ) {
				throw $e;
			}
	}

	function verifyAccount($email, $activation_code){
								
		$this->addCondition('email',$email);
		$this->tryLoadAny();
		if($this['activation_code']==$activation_code){
			$this['is_active']=true;
			$this->update();
			return true;
		}else
			return false;
	}

	function isDefaultSuperUser(){
		$first_super_user = $this->add('Model_Users');
		$first_super_user->addCondition('type',100);
		$first_super_user->setOrder('id');
		$first_super_user->loadAny();

		return $this->id == $first_super_user->id;
	}

	function isSuperUser(){
		return $this['type']==100;
	}

	function getDefaultSuperUser(){
		$this->addCondition('type',100);
		$this->setOrder('id');
		$this->loadAny();
		if($this->loaded()) return $this;
		return false;
	}

	function isFrontEndUser(){
		return $this['type'] == 50;
	}

	function isBackEndUser(){
		return $this['type'] >= 80;
	}

	function isMe(){
		return $this->id == $this->api->auth->model->id;
	}	

	function getAllowedApp(){
		$allowed_app= $this->ref('UserAppAccess')->addCondition('is_allowed',true)->_dsql()->del('fields')->field('installed_app_id')->getAll();
		return iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($allowed_app)),false);
	}

	function allowApp($installed_app_id){
		$acc = $this->add('Model_UserAppAccess');
		$acc->addCondition('user_id',$this->id);
		$acc->addCondition('installed_app_id',$installed_app_id);
		$acc->tryLoadAny();

		$acc['is_allowed'] =true;
		$acc->save();
	}

	function isAllowedApp($installed_app_id){
		$acc = $this->add('Model_UserAppAccess');
		$acc->addCondition('user_id',$this->id);
		$acc->addCondition('installed_app_id',$installed_app_id);
		$acc->tryLoadAny();

		return $acc->loaded();
	}

	function isUserManagementAllowed(){
		return $this['user_management'];
	}

	function isGeneralSettingsAllowed(){
		return $this['general_settings'];
	}

	function isApplicationManagementAllowed(){
		return $this['application_management'];
	}

	function isWebDesigningAllowed(){
		return $this['website_designing'];
	}

	function member(){
		if(!$this->loaded()) return false;

		return $this->add('xShop/Model_MemberDetails')->addCondition('users_id',$this->id);
	}

}
