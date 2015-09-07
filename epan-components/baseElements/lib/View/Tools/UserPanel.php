<?php

namespace baseElements;

class View_Tools_UserPanel extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	
	function init(){
		parent::init();

		//Setting Default Values
		$user_panel_name="Login ID";
		$user_panel_pass="Password";
		$user_panel_btn_login_name="Login";
		$user_panel_btn_registration_name="registration";
		$user_panel_verify="Verify";
		$user_panel_forgot_pass="Forgot password";
		$user_panel_activation_code="Re send Activation Code";
		$user_panel_btn_Verify_name="Verify";
		$user_panel_login_btn_css = "btn-block btn btn-success";

		if($this->html_attributes['user_panel_name'])
			$user_panel_name=$this->html_attributes['user_panel_name'];

		if($this->html_attributes['user_panel_pass'])
			$user_panel_pass=$this->html_attributes['user_panel_pass'];

		if($this->html_attributes['user_panel_verify_caption'])
			$user_panel_verify=$this->html_attributes['user_panel_verify_caption'];

		if($this->html_attributes['user_panel_btn_login_name'])
			$user_panel_btn_login_name=$this->html_attributes['user_panel_btn_login_name'];

		if($this->html_attributes['user_panel_verify_caption'])
			$user_panel_btn_Verify_name=$this->html_attributes['user_panel_verify_caption'];
		
		if($this->html_attributes['user_panel_forgot_pass'])
			$user_panel_forgot_pass=$this->html_attributes['user_panel_forgot_pass'];

		if($this->html_attributes['user_panel_activation_code'])
			$user_panel_activation_code=$this->html_attributes['user_panel_activation_code'];

		if($this->html_attributes['user_panel_btn_registration_name'])
			$user_panel_btn_registration_name=$this->html_attributes['user_panel_btn_registration_name'];
		
		if($this->html_attributes['user_panel_login_btn_css'])
			$user_panel_login_btn_css = $this->html_attributes['user_panel_login_btn_css'];
		
		
		//Show Desire Form (Registration/Forgot Password/Verify) if not logged In
		if(!$this->api->auth->isLoggedIn()){
			$this->api->stickyGET('new_registration');
			$this->api->stickyGET('verify_account');
			$this->api->stickyGET('forgot_password_view');

			//Add New Registration Form
			if($_GET['new_registration']){
				$this->api->stickyForget('new_registration');
				$this->add('baseElements/View_Registration',array('html_attributes'=>$this->html_attributes));

			}//Verify Account
			elseif($_GET['verify_account'] and $this->html_attributes['show_verify_me']){
				$this->add('baseElements/View_VerifyAccount',array('html_attributes'=>$this->html_attributes));
				
			}//Forgot Password
			elseif($_GET['forgot_password_view']){
				$this->add('baseElements/View_ForgotPassword',array('html_attributes'=>$this->html_attributes));

			}else{
				$this->add('baseElements/View_Login',array('html_attributes'=>$this->html_attributes));
			}

		}else{
			if($this->html_attributes['user_panel_after_login_page']){
				$this->api->redirect($this->api->url(null,array('subpage'=>$this->html_attributes['user_panel_after_login_page'])));
				// if($this->api->auth->model['is_active'])
					// $this->js(true)->univ()->redirect($this->api->url(null,array('subpage'=>$this->html_attributes['user_panel_after_login_page'])));
			}

			// create hello user panel
			if($this->html_attributes['user_panel_show_logout_view']){
				// $cols=$this->add('Columns');
				// $leftcol=$cols->addColumn(10);
				// $rightcol=$cols->addColumn(2);
				$str = "";
				$url = $this->html_attributes['user_panel_after_logout_page'];
				if(strpos($url, "http://") !== false){
					$str .= '<a class="xepan-user-logout-bth" href="index.php?page=epanlogout&logout_url='.$this->html_attributes['user_panel_after_logout_page'].'"> Logout</a>';
				}else
					$str .= '<a class="xepan-user-logout-bth" href="index.php?page=logout"> Logout</a>';
				
				$this->add('View')->setHTML('Hello '.$this->api->auth->model['username'].$str);
				
			}

		}

		if($this->html_attributes['show_register_new_user']){
			// $col = $cols->addColumn(4);
			$sign_up_field = $this->add('View')->setHTML($user_panel_btn_registration_name);
			//  = $form->add('Button')->set($user_panel_btn_registration_name);
			// $col->add($sign_up_field);
			$sign_up_field->js('click',$this->js()->reload(array('new_registration'=>1)));
		}
		
		if($this->html_attributes['show_forgot_password']){
			// $col = $cols->addColumn(4);
			$forgot_field = $this->add('View')->setHTML($user_panel_forgot_pass);
			$this->html_attributes['show_forgot_password'] = 0;
			$forgot_field->js('click',$this->js()->reload(array('forgot_password_view'=>1)));
		}	
		
		// if($this->html_attributes['user_panel_activation_code']){
		// 	$activation_field = $form->add('View')->setHTML($user_panel_activation_code)->setElement('a')->setAttr('href',$this->api->url(null,array('subpage'=>$this->html_attributes['user_panel_activation_code'])));
		// }
		
		if($this->html_attributes['show_verify_me']){
			// $col = $cols->addColumn(4);
			$verify_account=$this->add('View')->setHTML($user_panel_btn_Verify_name);
			$verify_account->js('click',$this->js()->reload(array('verify_account'=>1)));
		}
		
		$login = $this->add('View')->setHTML('Login');
		$login->js('click',$this->js()->reload(array('verify_account'=>0,'forgot_password_view'=>0,'new_registration'=>0)));


	}

	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}