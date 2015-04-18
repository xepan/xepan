<?php

class page_xHR_page_owner_employee_account extends Page{

	function init(){
		parent::init();

		if(!$_GET['employee_id'])
			return;
		
		$this->api->stickyGET('employee_id');
		$emp = $this->add('xHR/Model_Employee')->load($_GET['employee_id']);

		$form = $this->add('Form_Stacked');
		$active_user = $this->add('Model_Users')->addCondition('is_active', true);
		
		$form_field=$form->addField('autocomplete/Basic','user');
		$form_field->setModel($active_user);
		// $form_field->setEmptyText('Please Select User');
		$form_field->set($emp->user()->get('id'));
		$bs=$form_field->beforeField()->add('Button');


		if($bs->isClicked()){
			$emp['user_id']=0;
			$emp->save();
			$form->js()->univ()->successMessage('Cleared')->execute();
		}

		$form->addSubmit()->set('Update');

		if($form->isSubmitted()){
			$emp->makeUser($form['user']);
			$form->js(null,$form->js()->reload())->univ()->successMessage(' Update Information')->execute();
			// $form->js()->univ()->successMessage(' Update Information')->execute();
		}

	}
}