<?php

namespace baseElements;

class View_ForgotPassword extends \View{
	public $html_attributes=array(); // ONLY Available in server side components
	
	function init(){
		parent::init();
		
		//Show Forgot Password
				$this->api->stickyGET('forgot_password_view');
				$resend_form = $this->add('Form');
				if($this->html_attributes['form_stacked_on'])
						$resend_form->addClass('stacked');

				$email_field = $resend_form->addField('line','email','Registered Email Id')->validateNotNull()->validateField('filter_var($this->get(), FILTER_VALIDATE_EMAIL)');
				$email_field->setAttr('PlaceHolder','Enter your Registerd E-mail Id.');
				$btn = $resend_form->addSubmit('Send Activation Code');	
				
				if($resend_form->isSubmitted()){
					$user = $this->add('Model_Users');
					$user->addCondition('email',$resend_form['email']);
					$user->tryLoadAny();
					if($user->loaded())	{
						$user->sendVerificationMail($resend_form['email'],null,$user['activation_code']);											
						$resend_form->js(null,$this->js()->univ()->successMessage('Activation code Send to Registered Email id'))->reload(array('verify_account'=>1))->execute();							
						// $this->js('click',$this->js()->reload(array('verify_account'=>1)));		
					}
					$resend_form->js(null,$this->js()->univ()->errorMessage('Wrong Email id'))->reload()->execute();							
				}
	}
}