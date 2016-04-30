<?php

namespace baseElements;

class View_Login extends \View{
	public $html_attributes=array(); // ONLY Available in server side components
	
	function init(){
		parent::init();

			$this->addClass('xepan-login-panel');
			$user_panel_name=isset($this->html_attributes['user_panel_name'])?$this->html_attributes['user_panel_name']:"Login ID";
			$user_panel_pass=isset($this->html_attributes['user_panel_pass'])?$this->html_attributes['user_panel_pass']:"Password";
			$user_panel_btn_login_name=isset($this->html_attributes['user_panel_btn_login_name'])?$this->html_attributes['user_panel_btn_login_name']:"Login";
			$user_panel_login_btn_css = isset($this->html_attributes['user_panel_login_btn_css'])?$this->html_attributes['user_panel_login_btn_css']:"btn btn-default";

		// create login form
			if(isset($this->html_attributes['login_view']) and $this->html_attributes['login_view'] === "1"){
				$v = $this->add('View')->set('Login')->addClass('xepan-user-login-link');
				$v->setElement('a')->setAttr('href','index.php?subpage='.$this->html_attributes['user_panel_redirect_page']);
			}else{
				$this->add('View')->setElement('H2')->set('Login')->addClass('xepan-userpanel-header');
				$this->add('View')->setElement('div')->set('enter your username and password to log on')->addClass('xepan-userpanel-info atk-push');
				$form=$this->add('Form');
				//Set Form Stacked
				if(isset($this->html_attributes['form_stacked_on']))
					$form->addClass('stacked');
			
				$username_field = $form->addField('line','username',$user_panel_name)->validateNotNull();
				$password_field = $form->addField('password','password',$user_panel_pass)->validateNotNull();

				if($this->html_attributes['user_panel_username_placeholder'])
					$username_field->setAttr('placeHolder',$this->html_attributes['user_panel_username_placeholder']);
				if($this->html_attributes['user_panel_password_placeholder'])
					$password_field->setAttr('placeHolder',$this->html_attributes['user_panel_password_placeholder']);
				
				//add submit form
				$submit_field = $form->addButton($user_panel_btn_login_name);
				$submit_field->addClass($user_panel_login_btn_css);
				$submit_field->js('click',$form->js()->submit());
				

				$redirect_url = array('subpage'=>$this->html_attributes['user_panel_after_login_page']);
				// throw new \Exception($_GET['redirect'], 1);
				
				//Check for the checkout page
				// throw new \Exception($this->app->recall('next_url'), 1);
				
				if($this->app->recall('next_url')){
					$redirect_url = array('subpage'=>$this->api->recall('next_url'));
				}

					// $this->api->forget('next_url');
				if($form->isSubmitted()){
					// throw new \Exception(print_r($redirect_url));
					
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

					if($this->app->recall('next_url') And $this->app->recall('next_url_parameters')){
						$redirect_url=array('subpage'=>$this->api->recall('next_url'),'xsnb_item_id'=>$this->app->recall('next_url_parameters'));
					}
						$this->api->redirect($this->api->url(null,$redirect_url))->execute();
					// else
						$this->js()->reload()->execute();
				}
			}
	}
}