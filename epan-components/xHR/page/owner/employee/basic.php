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
													'name','empolyee_image_id','dob','doj',
													'gender','status','offer_date','confirmetion_date',
													'contract_end_date','date_of_retirement',
													'','blood_group',
													'marital_status','current_address','salary_mode','company_email_id',
													'permanent_addesss','mobile_no','personal_email',
													'family_background','health_details',
													'passport_no','passport_issue_date','passport_expiry_date',
													'passport_place_of_issue','emergency_contact_no','relation','emergency_contact_person'));
		$form->addSubmit()->set('Update');

		$form->add('Controller_FormBeautifier');
		if($form->isSubmitted()){	
			$form->update();
			$form->js()->univ()->successMessage(' Update Information')->execute();
		}

	}
}