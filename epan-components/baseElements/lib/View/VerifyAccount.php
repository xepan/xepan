<?php

namespace baseElements;

class View_VerifyAccount extends \View{
	public $html_attributes=array(); // ONLY Available in server side components
	
	function init(){
		parent::init();
		
		//Verify Account Form				
		$verify_user_model=$this->add('Model_Users');	
		
		$this->add('View')->setElement('H2')->set('Verification')->addClass('xepan-userpanel-header');
		$this->add('View')->setElement('div')->setHTML('enter your email id and verification code to verify your account.<br/> if you don\'t have verification code enter your registered email id and click resend activation code.')->addClass('xepan-userpanel-info atk-push');

		$verify_form=$this->add('Form');
		if($this->html_attributes['form_stacked_on'])
			$verify_form->addClass('stacked');

		$verify_form->addField('line','email_id')->validateNotNull();
		$verify_form->addField('line','verification_code');
		$submit_btn = $verify_form->addSubmit('Submit');
		$resend_btn = $verify_form->addSubmit('Resend Activation Code');

		if($_GET['activation_code']){
			$verify_form['verification_code']=$_GET['activation_code'];
		}

		if($_GET['activate_email']){
			$verify_form['email_id']=$_GET['activate_email'];
		}

		if($verify_form->isSubmitted()){
			if($verify_form->isClicked($submit_btn)){
				if(!trim($verify_form['verification_code']))
					$verify_form->error('verification_code','Verification Code is Mandatory Field');
				
				if(!$verify_user_model->verifyAccount($verify_form['email_id'],$verify_form['verification_code'])){
					$verify_form->js(null,$this->js()->univ()->errorMessage('Try Again'))->reload()->execute();		
				}

				$this->owner->js(null,$this->js()->univ()->successMessage('Account Verify Successfully'))->reload(array('user_selected_form'=>"login"))->execute();
			}

			if($verify_form->isClicked($resend_btn)){
				if(!$verify_user_model->isEmailExist($verify_form['email_id'])){
					$verify_form->error('email_id','Email id Not Registered');
				}

				$verify_user_model->sendVerificationMail($verify_form['email_id'],null,rand(100000,999999));							
				$verify_form->js(null,$this->js()->univ()->successMessage('Email Send Successfully'))->reload()->execute();
			}			
			
			$this->api->stickyForget('verify_account');
		} 
	}
}