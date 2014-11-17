<?php
class page_owner_users extends page_base_owner {

	function page_index(){

		$this->add( 'H3' )->setHTML( "<i class='fa fa-users'></i> User Management <small>Manage your website / applications registered users</small>" );

		$crud=$this->add('CRUD');
		$usr=$this->add('Model_Users');
		$usr->addCondition('epan_id',$this->api->current_website->id);
		
		$crud->setModel($usr);
		$crud->add('Controller_FormBeautifier',array('params'=>array('f/addClass'=>'stacked')));

		if($crud->grid){
			$crud->add_button->setIcon('ui-icon-plus');
			$op_btn = $crud->grid->addButton('Options');
			$op_btn->setIcon('ui-icon-gear');
			$op_btn->js('click',$this->js()->univ()->frameURL('User Options',$this->api->url('./options')));
			// $crud->grid->addButton('Email Config')->js('click',$this->js()->univ()->frameURL('User Email Configuration',$this->api->url('./emailconfig')));
			$cust_btn = $crud->grid->addButton('User Custom Fields');
			$cust_btn->setIcon('ui-icon-wrench');
			$cust_btn->js('click',$this->js()->univ()->frameURL('User Custom Fields ',$this->api->url('./customfieldconfig')));
		}
	}

	function page_options(){
		$form = $this->add('Form');
		$form->addClass('stacked');
		$form->setModel($this->api->current_website,array('is_frontent_regiatrstion_allowed','user_activation','user_registration_email_subject','user_registration_email_message_body'));
		$form->addSubmit('Update');
		$form->add('Controller_FormBeautifier');
		if($form->isSubmitted()){
			$form->update();
			$form->js(null,$form->js()->univ()->successMessage('Options Updated'))->univ()->closeDialog()->execute();
		}
	}

	function page_emailconfig(){
		$form = $this->add('Form');
		$form->addClass('stacked');
		$form->setModel($this->api->current_website,array('user_registration_email_subject','user_registration_email_message_body'));
		$form->addSubmit('save');
		if($form->isSubmitted()){
			$form->update();
			$form->js(null,$form->js()->univ()->successMessage('Email Config Updated'))->univ()->closeDialog()->execute();
		}
	}

	function page_customfieldconfig(){
		$usercustomfield_model = $this->add('Model_UserCustomFields');
		$crud = $this->add('CRUD');
		$crud->setModel($usercustomfield_model);
		$crud->add('Controller_FormBeautifier');

	}
}
