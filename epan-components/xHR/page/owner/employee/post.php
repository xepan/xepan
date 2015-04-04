<?php

class page_xHR_page_owner_employee_post extends Page{
	function init(){
		parent::init();

		$employee_id = $this->api->stickyGET('employee_id');
		$employee = $this->add('xHR/Model_Employee')->load($employee_id);

		
		$post = $this->add('xHR/Model_Post');
		$form=$this->add('Form');
		$post_field = $form->addField('Dropdown','post');
		$post_field->setModel($post);
		$form->addSubmit('Update');

		$post_field->set($employee->post()->get('id'));

		if($form->isSubmitted()){	
			$employee['post_id'] = $form['post'];
			$employee->save();
			$form->js(null,$form->js()->reload())->univ()->successMessage(' Update Information')->execute();
			// $form->js()->univ()->successMessage(' Update Information')->execute();
		}
	}
}