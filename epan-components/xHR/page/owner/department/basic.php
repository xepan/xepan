<?php
class page_xHR_page_owner_department_basic extends Page{

	function init(){
		parent::init();

		if(!$_GET['hr_department_id'])
			throw new \Exception($_GET['hr_department_id']);
			
			// return;
		
		$this->api->stickyGET('hr_department_id');
		$selected_dept_model = $this->add('xHR/Model_Department')->load($_GET['hr_department_id']);		
		if(!$selected_dept_model->loaded())
			return;
		
		$form = $this->add('Form_Stacked');
		$form->setModel($selected_dept_model,array('name','production_level','is_active'));
		$form->addSubmit()->set('Update');

		$form->add('Controller_FormBeautifier');
		if($form->isSubmitted()){	
			$form->update();
			$form->js(null,$form->js()->reload())->univ()->successMessage(' Update Information')->execute();
			// $form->js()->univ()->successMessage('Department Updtaed')->execute();
		}

	}
}