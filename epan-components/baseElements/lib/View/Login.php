<?php

namespace baseElements;

class View_Login extends \View{
	public $html_attributes=array(); // ONLY Available in server side components
	
	function init(){
		parent::init();
			$user_panel_name="Login ID";
			$user_panel_pass="Password";
			$user_panel_btn_login_name="Login";
			$user_panel_login_btn_css = "btn-block btn btn-success";
			$user_panel_btn_login_name="Login";
			$user_panel_btn_registration_name="registration";
			$user_panel_verify="Verify";
			$user_panel_forgot_pass="Forgot password";
			$user_panel_btn_Verify_name="Verify";
		// create login form
				if($this->html_attributes['login_view']){
					$v = $this->add('View')->set('Login')->addClass('xepan-user-login-link');
					$v->setElement('a')->setAttr('href','index.php?subpage='.$this->html_attributes['user_panel_redirect_page']);
				}else{
					$form=$this->add('Form');
					if($this->html_attributes['form_stacked_on'])
						$form->addClass('stacked');
					
					$username_field = $form->addField('line','username',$user_panel_name)->validateNotNull();
					$password_field = $form->addField('password','password',$user_panel_pass)->validateNotNull();

					if($this->html_attributes['user_panel_username_placeholder'])
						$username_field->setAttr('placeHolder',$this->html_attributes['user_panel_username_placeholder']);
					if($this->html_attributes['user_panel_password_placeholder'])
						$password_field->setAttr('placeHolder',$this->html_attributes['user_panel_password_placeholder']);
					
					//add submit form
					// $submit_field = $form->addSubmit($user_panel_btn_login_name);
					$submit_field = $form->addButton($user_panel_btn_login_name);
					$submit_field->addClass($user_panel_login_btn_css);
					$submit_field->js('click',$form->js()->submit());
					// $cols = $this->add('Columns');

					
					// $submit_field->js(true)->appendTo($col);//->add($submit_field);
					// $form->js(true)->find('.atk-buttons')->removeClass('atk-buttons');
					
					$redirect_url = array('subpage'=>$this->html_attributes['user_panel_after_login_page']);
					//Check for the checkout page
					$redirect_url = $this->api->recall('next_url',$redirect_url);
						// $this->api->forget('next_url');
					if($form->isSubmitted()){
						// $this->api->auth->addEncryptionHook($user_model);
						// $user_model->addCondition('username',$form['username']);
						// $user_model->addCondition('password',$this->api->auth->encryptPassword($form['password']));
						// $user_model->tryLoadAny();
						$this->api->auth->model->allow_duplicate_email=true;
						if(!($id = $this->api->auth->verifyCredentials($form['username'],$form['password'])))
							$form->displayError('username','Wrong Credentials');

						$user_model = $this->add('Model_Users')->load($id);
						if(!$user_model['is_active'])
							$form->displayError('username','Please Activate Your Account First');

						//save into Cookies
						//end of saving into cookies
						// $this->app->auth->addEncryptionHook($user_model);
						$this->api->auth->login($form['username']);
						// if reload page
						$this->api->redirect($this->api->url(null,$redirect_url))->execute();
						// else
							$this->js()->reload()->execute();
					}
				}
	}
}