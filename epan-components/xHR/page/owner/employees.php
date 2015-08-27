<?php
class page_xHR_page_owner_employees extends page_xProduction_page_owner_main{
	function init(){
		parent::init();

		$this->app->title=$this->api->current_department['name'] .': Employee';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> Employee Management <small> Manage companies employees </small>');

		$emp_model=$this->add('xHR/Model_Employee');
		$emp_crud = $this->add('CRUD',array('grid_class'=>'xHR/Grid_Employee','allow_edit'=>false));
		$emp_crud->setModel($emp_model,array('empolyee_image','name','post_id','department_id','user_id','department','post'
											 ,'user','dob','gender',
											 'is_active','name_with_designation',
											 'status','doj','company_email_id',
											 'offer_date','confirmation_date',
											 'contract_end_date','date_of_retirement',
											 'resignation_letter_date','seen_till',
											 'mobile_no','relation','emergency_contact_person',
											 'emergency_contact_no','permanent_addesss',
											 'current_address','personal_email','passport_no',
											 'passport_issue_date','passport_expiry_date',
											 'passport_place_of_issue','blood_group',
											 'marital_status','family_background','health_details',
											 'qualifiction','qualifiction_level','pass',
											 'major_optional_subject','previous_work_company',
											 'previous_company_address','previous_work_designation',
											 'from_date','previous_company_branch',
											 'previous_work_salary','previous_company_department',
											 'to_date','pre_resignation_letter_date',
											 'pre_relieving_date','pre_reason_of_resignation'));
		
	}
}