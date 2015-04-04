<?php

class page_xHR_page_owner_employee_workexperience extends Page{
	function init(){
		parent::init();

		if(!$_GET['employee_id'])
			// throw new \Exception($_GET['department_id']);
			
			return;
		
		$this->api->stickyGET('department_id');
		$selected_dept_model = $this->add('xHR/Model_Employee')->load($_GET['employee_id']);		
		if(!$selected_dept_model->loaded())
			return;
		
		$form = $this->add('Form_Stacked');
		$form->setModel($selected_dept_model,array('previous_work_company','previous_company_address','previous_work_designation','previous_company_branch','previous_work_salary','previous_company_department','from_date','to_date','pre_resignation_letter_date','pre_relieving_date','pre_reason_of_resignation'));
		$form->addSubmit()->set('Update');

		$form->add('Controller_FormBeautifier');
		if($form->isSubmitted()){	
			$form->update();
			$form->js(null,$form->js()->reload())->univ()->successMessage(' Update Information')->execute();
			// $form->js()->univ()->successMessage(' Update Information')->execute();
		}

	}
	
}