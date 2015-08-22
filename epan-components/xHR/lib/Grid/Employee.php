<?php

namespace xHR;
class Grid_Employee extends \Grid{
	function init(){
		parent::init();

		$this->add('VirtualPage')->addColumn('Details','Details',array('icon'=>'users'),$this)->set(function($p){

				$selected_emp = $p->add('xHR/Model_Employee')->load($p->id);

				$tab = $p->add('Tabs');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_basic',array('employee_id'=>$p->id)),'Basic');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_qualification',array('employee_id'=>$p->id)),'Qualification');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_media',array('employee_id'=>$p->id)),'Media');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_workexperience',array('employee_id'=>$p->id)),'Work Experience');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_department',array('employee_id'=>$p->id)),'Department');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_account',array('employee_id'=>$p->id)),'User Account');
				$tab->addTabURL($p->api->url('xHR_page_owner_employee_employeeemail',array('employee_id'=>$p->id)),'Employee Email');
		});
	}
 
	function setModel($model,$fields=null){
		if(!$fields)
			$fields = $model->getActualFields();
		$m= parent::setModel($model,$fields);
		$this->addQuickSearch($fields,null,'xHR/Filter_Employee');
	
		$this->fooHideAlways('name_with_designation');
		$this->fooHideAlways('status');
		$this->fooHideAlways('blood_group');
		$this->fooHideAlways('marital_status');
		$this->fooHideAlways('company_email_id');
		$this->fooHideAlways('offer_date');
		$this->fooHideAlways('qualifiction');
		$this->fooHideAlways('qualifiction_level');
		$this->fooHideAlways('pass');
		$this->fooHideAlways('major_optional_subject');
		$this->fooHideAlways('emergency_contact_person');
		$this->fooHideAlways('relation');
		$this->fooHideAlways('emergency_contact_no');
		$this->fooHideAlways('current_address');
		$this->fooHideAlways('permanent_addesss');
		$this->fooHideAlways('family_background');
		$this->fooHideAlways('health_details');
		$this->fooHideAlways('confirmation_date');
		$this->fooHideAlways('contract_end_date');
		$this->fooHideAlways('date_of_retirement');
		$this->fooHideAlways('resignation_letter_date');
		$this->fooHideAlways('seen_till');
		$this->fooHideAlways('passport_no');
		$this->fooHideAlways('passport_issue_date');
		$this->fooHideAlways('passport_expiry_date');
		$this->fooHideAlways('passport_place_of_issue');
		$this->fooHideAlways('previous_work_company');
		$this->fooHideAlways('previous_company_branch');
		$this->fooHideAlways('previous_company_department');
		$this->fooHideAlways('previous_company_address');
		$this->fooHideAlways('previous_work_designation');
		$this->fooHideAlways('previous_work_salary');
		$this->fooHideAlways('to_date');
		$this->fooHideAlways('pre_resignation_letter_date');
		$this->fooHideAlways('pre_relieving_date');
		$this->fooHideAlways('pre_reason_of_resignation');
		$this->fooHideAlways('gender');
		$this->fooHideAlways('is_active');


		if($this->hasColumn('user_id'))$this->removeColumn('user_id');
		if($this->hasColumn('department_id'))$this->removeColumn('department_id');
		if($this->hasColumn('post_id'))$this->removeColumn('post_id');
		if($this->hasColumn('from_date'))$this->removeColumn('from_date');

		$this->addFormatter('empolyee_image','imageThumbnail');

		return $m;
	}


	function formatRow(){
		
		$class = $this->model['is_active']?'atk-effect-success':'atk-effect-danger';
		$this->current_row_html['name'] = '<div class="'.$class.'">'.$this->model['name'].'</div>';
		parent::formatRow();
	}

	function recursiveRender(){
		parent::recursiveRender();
	}

}