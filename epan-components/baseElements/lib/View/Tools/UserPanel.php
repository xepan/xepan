<?php

namespace baseElements;

class View_Tools_UserPanel extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	
	function init(){
		parent::init();

		$this->addClass('xepan-user-login-panel');
		//Setting Default Values
		$user_panel_btn_registration_name = isset($this->html_attributes['user_panel_btn_registration_name'])?$this->html_attributes['user_panel_btn_registration_name']:'Registration';
		$user_panel_forgot_pass=isset($this->html_attributes['user_panel_forgot_pass'])?$this->html_attributes['user_panel_forgot_pass']:'Forgot password';
		$user_panel_btn_Verify_name=isset($this->html_attributes['user_panel_verify_caption'])?$this->html_attributes['user_panel_verify_caption']:'Verify';
		
		//Show Desire Form (Registration/Forgot Password/Verify) if not logged In
		if(!$this->api->auth->isLoggedIn()){
			$this->api->stickyGET('user_selected_form');
			
			//Set Display Form Variable According to Default Form or user selected form 
			$display = $this->html_attributes['default_login_view']?:'login';
			//Set view According to GET Value
			if(isset($_GET['user_selected_form'])){
				$display = $_GET['user_selected_form'];
			}

			//IF View setted as Short Login View then show always short login view -----Region two Login View on one page
			if(isset($this->html_attributes['login_view']) and $this->html_attributes['login_view'] === "1")
				$display = 'login';

			switch ($display) {
				case 'login':
					$this->add('baseElements/View_Login',array('html_attributes'=>$this->html_attributes));
				break;
				case 'forget_password':
					$this->add('baseElements/View_ForgotPassword',array('html_attributes'=>$this->html_attributes));

				break;
				case 'verify_account':
					$this->add('baseElements/View_VerifyAccount',array('html_attributes'=>$this->html_attributes));
				break;
				case 'new_registration':
					$this->add('baseElements/View_Registration',array('html_attributes'=>$this->html_attributes));
				break;
			}

			//Add Short Linkes for Login Options
			//if login view he to don't sho

			if(!isset($this->html_attributes['login_view']) or $this->html_attributes['login_view'] == "0"){
				$bottom_view = $this->add('View')->addClass('xepan-user-panel-shortlink');
				if($display !== 'login'){
					$login = $bottom_view->add('View')->setHTML('Login')->addClass('xepan-login-link');
					$login->js('click',$this->js()->reload(array('user_selected_form'=>'login')));
				}

				if($this->html_attributes['show_register_new_user'] and $display !== 'new_registration'){
					$sign_up_field = $bottom_view->add('View')->setHTML($user_panel_btn_registration_name)->addClass('xepan-login-registration-link');
					$sign_up_field->js('click',$this->js()->reload(array('user_selected_form'=>'new_registration')));
				}
				if($this->html_attributes['show_forgot_password'] and $display !== 'forget_password'){
					$forgot_field = $bottom_view->add('View')->setHTML($user_panel_forgot_pass)->addClass('xepan-login-forget-password-link');
					$forgot_field->js('click',$this->js()->reload(array('user_selected_form'=>'forget_password')));
				}
				
				if( $this->html_attributes['show_verify_me'] and $display !== 'verify_account'){
					$verify_account=$bottom_view->add('View')->setHTML($user_panel_btn_Verify_name)->addClass('xepan-login-verify-account-link');
					$verify_account->js('click',$this->js()->reload(array('user_selected_form'=>'verify_account')));
				}
			}
				

		}else{
			if($this->html_attributes['user_panel_after_login_page']){
				$this->api->redirect($this->api->url(null,array('subpage'=>$this->html_attributes['user_panel_after_login_page'])));
			}




			// create hello user View
			if($this->html_attributes['user_panel_show_logout_view']){
				$str = "";
				$url = $this->html_attributes['user_panel_after_logout_page'];
				//display user name or not
				$view="";
				if(!$this->html_attributes['show_name_or_username']){
					$logout_prefix = isset($this->html_attributes['user_panel_logout_prefix'])?$this->html_attributes['user_panel_logout_prefix']:"Hello ";
					$view=$this->add('View')->setHTML($logout_prefix.$this->api->auth->model['username'].$str);
				}
				$logout_caption = isset($this->html_attributes['user_panel_logout_caption'])?$this->html_attributes['user_panel_logout_caption']:"Logout ";
				if(strpos($url, "http://") !== false){
					$str .= '<a class="xepan-user-logout-bth" href="index.php?page=epanlogout&logout_url='.$this->html_attributes['user_panel_after_logout_page'].'">'.$logout_caption.'</a>';
				}else
					$str .= '<a class="xepan-user-logout-bth" href="index.php?page=logout"> '.$logout_caption.'</a>';

				$this->add('View')->setHTML($str);
			}

		}

	}

	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}