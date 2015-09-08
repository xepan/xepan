<?php

namespace baseElements;

class View_VerifyAccount extends \View{
	public $html_attributes=array(); // ONLY Available in server side components
	
	function init(){
		parent::init();
		
		//Verify Account Form				
				$verify_user_model=$this->add('Model_Users');	
							
				$verify_form=$this->add('Form');
				if($this->html_attributes['form_stacked_on'])
					$verify_form->addClass('stacked');

				$verify_form->addField('line','email_id');
				$verify_form->addField('line','verification_code');
				$verify_form->addSubmit('Submit');

				if($_GET['activation_code']){
					$verify_form['verification_code']=$_GET['activation_code'];
				}

				if($_GET['activate_email']){
					$verify_form['email_id']=$_GET['activate_email'];
				}

				if($verify_form->isSubmitted()){
					if(!$verify_user_model->verifyAccount($verify_form['email_id'],$verify_form['verification_code'])){
						$verify_form->js(null,$this->js()->univ()->errorMessage('Try Again'))->reload()->execute();		
					}					
					$this->api->stickyForget('verify_account');
					$verify_form->js(null,$this->js()->univ()->successMessage('Account Verify Successfully'))->reload()->execute();	
				} 
	}
}