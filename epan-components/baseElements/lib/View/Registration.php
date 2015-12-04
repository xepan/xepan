<?php

namespace baseElements;

class View_Registration extends \View{
	public $html_attributes=array(); // ONLY Available in server side components
	
	function init(){
		parent::init();
		
		$r_form = $this->add('Form');
		if($this->html_attributes['form_stacked_on'])
			$r_form->addClass('stacked');

		$r_form->addField('line','first_name')->validateNotNull(true);
		$r_form->addField('line','last_name')->validateNotNull(true);
		$r_form->addField('line','email_id')->validateNotNull()->validateField('filter_var($this->get(), FILTER_VALIDATE_EMAIL)');
		$r_form->addField('password','password')->validateNotNull(true);
		$r_form->addField('password','re_password')->validateNotNull(true);

		$custome_field = $this->add('Model_UserCustomFields');
		if($custome_field->getCount($this->api->current_website->id) > 0){
			foreach ($custome_field as $junk) {		
				if($junk['type']=='captcha'){
					$captcha_field=$r_form->addField('line','captcha');
					$captcha_field->belowField()->add('H4')->set('Please enter the code shown above');
					$captcha_field->add('x_captcha/Controller_Captcha');
					}
					// elseif($junk['mandatory']){
					// 	$field=$r_form->addField($custome_field['type'],$this->api->normalizeName($custome_field['name']),$custome_field['name'])->validateNotNull(true);
					else{
						$field=$r_form->addField($custome_field['type'],$this->api->normalizeName($custome_field['name']),$custome_field['name']);
					}

				if($custome_field['is_expandable']){		
					$new_arr =explode(',', $custome_field['set_value']);
					$to_put=array();
					foreach ($new_arr as $value) {
						$to_put[$value] = $value;
					}
					$field->setValueList($to_put);
				}

				if($custome_field['change']){
					$to_array  = json_decode($custome_field['change'],true);
					// echo $custome_field['change'];
					// print_r($to_array);
					$normalized_array=array();
					foreach ($to_array as $val => $fields) {
						foreach ($fields as &$fld) {
							$normalized_array[$val][]=$this->api->normalizeName($fld);
						}
					}
					// print_r($normalized_array);

					$field->js(true)->univ()->bindConditionalShow($normalized_array,'div .atk-form-row');
				}

			}

		}
								
		$r_form->addSubmit('submit')->set('Register');

		if($r_form->isSubmitted()){
					
			if( $r_form['password'] != $r_form['re_password']){
				$r_form->displayError('password','Password not match');
			}

			// check mandatories 
			$form= $r_form;
			$custome_field_mendatory_check = $this->add('Model_UserCustomFields');
			$custome_field_mendatory_check->addCondition('epan_id',$this->api->current_website->id);

			foreach ($custome_field_mendatory_check as $junk) {
				if($junk['mandatory']){
					// check if it is in any condistional show
					$allfields_with_custom = $this->add('Model_UserCustomFields');
					$allfields_with_custom->addCondition('epan_id',$this->api->current_website->id);
					$allfields_with_custom->addCondition(
						$allfields_with_custom->dsql()->orExpr()
							->where('change','<>','')
							->where('change','<>',null)
						);
					$allfields_with_custom->addCondition('change','like','%'.$junk['name'].'%');
					$found_in_condition=false;
					foreach ($allfields_with_custom as $junk_all_field) {
					// if yes
						// check if fields value is the one when it is shown
						$change_array = json_decode($allfields_with_custom['change'],true);
						if(in_array($junk['name'], $change_array[$value])){
								$found_in_condition=true;
						}
						foreach ($change_array as $value => $fields_to_show) {
							if( $form[$this->api->normalizeName($allfields_with_custom['name'])] == $value AND in_array($junk['name'], $change_array[$value]) and !$form[$this->api->normalizeName($junk['name'])]){
							// if empty
								// display error
								$form->displayError($this->api->normalizeName($junk['name']),'Must fill');
							}
						}
						
					}
					// if no
						// if value is empty display error
					if(!$found_in_condition and !$form[$this->api->normalizeName($custome_field_mendatory_check['name'])])
						$form->displayError($this->api->normalizeName($custome_field_mendatory_check['name']),'Must Fill ...');
				}
			}

			$user_model=$this->add('Model_Users');
			
			if($user_model->isEmailExist($r_form['email_id'])){
				$r_form->displayError('email_id','Email id Already Taken, Choose Another');
			}

			$user_model['name'] = $r_form['first_name']." ".$r_form['last_name'];
			$user_model['email'] = $r_form['email_id'];
			$user_model['username'] = $r_form['email_id'];
			$user_model['password'] = $r_form['password'];
			$user_model['created_at'] = date('Y-m-d');
			$user_model['type'] = 50;
			$user_model['activation_code'] = rand(9999,100000);
			// $user_model['epan_id'] = $this->api->current_website->id;
			$this->app->auth->addEncryptionHook($user_model);
			if($this->api->current_website['user_activation']=='default_activated'){
				$user_model['is_active'] = 1;
				$user_model->save();
				}
			elseif($this->api->current_website['user_activation']=='self_activated'){
				$user_model['is_active'] = 0;
				$user_model->save();
				$user_model->sendVerificationMail($user_model['email'],null,$user_model['activation_code']);
			}else{
				$user_model->save();						
			}

			$custome_field_model = $this->add('Model_UserCustomFields');
			$custome_field_model->addCondition('epan_id',$this->api->current_website->id);
			
			$allFields = $form->getAllFields();
			
			foreach ($custome_field_model as $junk) {
				$custom_field_value_model = $this->add('Model_UserCustomFieldValue');
				$custom_field_value_model->createNew($user_model['id'],$junk['id'],$allFields[$this->api->normalizeName($junk['name'])]);
			}
			
			$reload_after_view = $this->html_attributes['default_login_view']?:"login";
			if($this->html_attributes['show_verify_me'])
				$reload_after_view = "verify_account";

			$this->owner->js(null,$this->js()->univ()->successMessage('Account Created Successfully'))->reload(array('user_selected_form'=>$reload_after_view))->execute();
			
		}		
	}
}