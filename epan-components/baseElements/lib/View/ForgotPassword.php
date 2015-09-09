<?php

namespace baseElements;

class View_ForgotPassword extends \View{
	public $html_attributes=array(); // ONLY Available in server side components
	public $update_password = false;
	function init(){
		parent::init();
		
		if(isset($_REQUEST['update_password']) and $_REQUEST['update_password'] === "true"){
			
			$this->api->stickyGET('update_password');

			$form = $this->add('Form');
			if($this->html_attributes['form_stacked_on'])
					$form->addClass('stacked');
			
			$email_field = $form->addField('line','email','Registered Email Id')->validateNotNull()->validateField('filter_var($this->get(), FILTER_VALIDATE_EMAIL)');
			$email_field->setAttr('PlaceHolder','Enter your Registerd E-mail Id');			

			$email_field->set($_GET['activate_email']);
			$form->addField('line','activation_code')->set($_GET['activation_code']);
			$form->addField('password','new_password')->validateNotNull();
			$form->addField('password','re_password')->validateNotNull();

			$form->addSubmit('Update');
			if($form->isSubmitted()){

				if($form['new_password'] !== $form['re_password'])
					$form->displayError('new_password','password must match');

				$user = $this->add('Model_Users');
				$user->addCondition('email',$form['email']);
				$user->tryLoadAny();

				if($user->loaded())	{
					if($user['activation_code'] != $form['activation_code'])
						$form->displayError('activation_code','Wrong activation code');

					$user['password'] = $form['password'];
					$user->save();
					$user->sendPasswordUpdateMail();
					$form->js(null,$form->js()->univ()->successMessage('Password Update Successfully'))->reload(array('user_selected_form'=>'login'))->execute();
				}

				$form->js(null,$form->js()->univ()->errorMessage('Wrong Email id'))->reload()->execute();
			}

		}else{

			//Show Forgot Password
			$resend_form = $this->add('Form');
			if($this->html_attributes['form_stacked_on'])
					$resend_form->addClass('stacked');

			$email_field = $resend_form->addField('line','email','Registered Email Id')->validateNotNull()->validateField('filter_var($this->get(), FILTER_VALIDATE_EMAIL)');
			$email_field->setAttr('PlaceHolder','Enter your Registerd E-mail Id');

			$btn = $resend_form->addSubmit('Send Activation Code');

			if($resend_form->isSubmitted()){
				$user = $this->add('Model_Users');
				$user->addCondition('email',$resend_form['email']);
				$user->tryLoadAny();

				if($user->loaded())	{
					$user->sendPasswordVerificationMail();
					$resend_form->js(null,$resend_form->js()->univ()->successMessage('Activation code Send to Registered Email id'))->reload(array('user_selected_form'=>'verify_account'))->execute();
				}
				$resend_form->js(null,$resend_form->js()->univ()->errorMessage('Wrong Email id'))->reload()->execute();
			}
		}


	}
}