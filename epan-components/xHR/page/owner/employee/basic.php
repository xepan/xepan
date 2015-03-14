<?php
class page_xHR_page_owner_employee_basic extends Page{

	function init(){
		parent::init();

		if(!$_GET['employee_id'])
			// throw new \Exception($_GET['department_id']);
			
			return;
		
		$this->api->stickyGET('employee_id');
		$selected_dept_model = $this->add('xHR/Model_Employee')->load($_GET['employee_id']);		
		if(!$selected_dept_model->loaded())
			return;
		
		$form = $this->add('Form_Stacked');
		$form->setModel($selected_dept_model,array(
													'name','dob','gender', 
													'status','doj','offer_date','company_email_id','confirmation_date','contract_end_date','date_of_retirement','resignation_letter_date'
													,'relieving_date','reason_of_resignation','salary_mode','feedback','mobile_no',													// 'marital_status','salary_mode','company_email_id',
													'emergency_contact_person','relation','emergency_contact_no','current_address','permanent_addesss',
													 'personal_email','passport_no','passport_issue_date','passport_expiry_date','passport_place_of_issue','blood_group','marital_status'
    												,'family_background','health_details'													

													));
		$form->addSubmit()->set('Update');

		$form->add('Controller_FormBeautifier');
		if($form->isSubmitted()){	
			$form->update();
			$form->js()->univ()->successMessage(' Update Information')->execute();
		}

	}
}