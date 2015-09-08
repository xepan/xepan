<?php

namespace baseElements;

class View_Tools_UserPanel extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	
	function init(){
		parent::init();

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
				if($display !== 'login'){
					$login = $this->add('View')->setHTML('Login');
					$login->js('click',$this->js()->reload(array('user_selected_form'=>'login')));
				}

				if($display !== 'new_registration'){
					$sign_up_field = $this->add('View')->setHTML($user_panel_btn_registration_name);
					$sign_up_field->js('click',$this->js()->reload(array('user_selected_form'=>'new_registration')));
				}
				
				if($display !== 'forget_password'){
					$forgot_field = $this->add('View')->setHTML($user_panel_forgot_pass);
					$forgot_field->js('click',$this->js()->reload(array('user_selected_form'=>'forget_password')));
				}
				
				if($display !== 'verify_account'){
					$verify_account=$this->add('View')->setHTML($user_panel_btn_Verify_name);
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
				$logout_prefix = isset($this->html_attributes['user_panel_logout_prefix'])?$this->html_attributes['user_panel_logout_prefix']:"Hello ";
				$logout_caption = isset($this->html_attributes['user_panel_logout_caption'])?$this->html_attributes['user_panel_logout_caption']:"Logout ";
				if(strpos($url, "http://") !== false){
					$str .= '<a class="xepan-user-logout-bth" href="index.php?page=epanlogout&logout_url='.$this->html_attributes['user_panel_after_logout_page'].'">'.$logout_caption.'</a>';
				}else
					$str .= '<a class="xepan-user-logout-bth" href="index.php?page=logout"> '.$logout_caption.'</a>';

				$this->add('View')->setHTML($logout_prefix.$this->api->auth->model['username'].$str);
			}

		}

	}

	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}