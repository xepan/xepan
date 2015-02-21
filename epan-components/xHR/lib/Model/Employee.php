<?php
namespace xHR;

class Model_Employee extends \Model_Table{
	public $table="xhr_employees";
	function init(){
		parent::init();

		$this->hasOne('Users','user_id');
		$this->hasOne('xHR/Department','department_id');
		$this->hasOne('xHR/Post','post_id')->group('a~3~Basic Inf0');

		$this->addField('name')->Caption('Full Name')->group('a~4');
		$this->addField('dob')->type('date')->Caption('Date Of Birth')->group('a~2');
		$this->addField('doj')->type('date')->Caption('Date Of Joining')->group('a~2');
		$this->add('filestore/Field_Image','empolyee_image_id');
		// $this->addField('image_url')->mandatory(true)->display(array('form'=>'ElImage'));
		$this->addField('gender')->enum(array('male','female'))->group('a~2');

		$this->addField('status')->enum(array('active','left'))->group('b~4~Employment Details');
		$this->addField('offer_date')->type('date')->group('b~2');
		$this->addField('confirmetion_date')->type('date')->group('b~2');
		$this->addField('contract_end_date')->type('date')->group('b~2');
		$this->addField('date_of_retirement')->type('date')->group('b~2');
		$this->addField('permanent_addesss')->type('text')->group('b~6');
		$this->addField('current_address')->type('text')->group('b~6');//->enum(array('rentend','owned'));

		$this->addField('salary_mode')->enum(array('cheque','cash','bank'))->group('c~6~Job Profile');
		$this->addField('company_email_id')->group('c~6');

		$this->addField('mobile_no')->type('Number')->group('d~6~Contact Details');
		$this->addField('personal_email')->group('d~6');

		$this->addField('emergency_contact_no')->type('Number')->group('e~4~Emergency Contact Details');
		$this->addField('relation')->group('e~4');
		$this->addField('emergency_contact_person')->group('e~4');

		$this->addField('passport_no')->group('f~4~Personal Details');
		$this->addField('passport_issue_date')->type('date')->group('f~2');
		$this->addField('passport_expiry_date')->type('date')->group('f~2');
		$this->addField('passport_place_of_issue')->group('f~4');
		$this->addField('blood_group')->group('f~6');
		$this->addField('marital_status')->enum(array('single','married','divorced','widowed'))->group('f~6');//->display(array('form'=>'Radio'));
		$this->addField('family_background')->type('text')->hint('Here You Can Maintain Family Details like name and occuptation of parent , spouse and Children')->group('f~6');
		$this->addField('health_details')->type('text')->hint('Here You can Maintain Height, Weight, allergies, Medicals Concerns etc.')->group('f~6');
		$this->addField('qualifiction')->group('g~2~Educational Qualification'); 
		$this->addField('qualifiction_level')->enum(array('Graduate','Post Graduate','Under Graduate'))->group('g~2');//->display(array('form'=>'Radio'));
		$this->addField('pass')->Caption('Percent / Division')->group('g~2');
		$this->addField('major_optional_subject')->type('text')->group('g~2');
		
		$this->addField('previous_work_company')->group('h~4~Previous Work Expriences');
		$this->addField('previous_work_designation')->group('h~4');
		$this->addField('previous_company_branch')->group('h~4');
		$this->addField('previous_work_salary')->group('h~3');
		$this->addField('previous_company_department')->group('h~3');
		$this->addField('from_date')->type('date')->group('h~3');
		$this->addField('to_date')->type('date')->group('h~3');
		$this->addField('previous_company_address')->type('text')->group('h~6');
		$this->addField('resignation_letter_date')->type('date')->group('i~2~EXIT');
		$this->addField('resion_of_resignation')->type('date')->group('i~2');
		$this->addField('relieving_date')->type('date')->group('i~2');
		$this->addField('leave_encashed')->enum(array('yes','no'))->display(array('form'=>'Radio'))->Caption('Leave EnCashed ?')->group('i~2');
		$this->addField('encashment_date')->type('date')->group('i~2');
		$this->addField('feedback')->type('text')->group('i~2');
		
		$this->hasMany('xHR/Salary','employee_id');
		$this->hasMany('xProduction/JobCardEmployeeAssociation','employee_id');
		$this->hasMany('xProduction/EmployeeTeamAssociation','employee_id');

		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);
		
		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required?type your name here',
							// 'company_email_id|email|unique','if','*','[company_email_id]'
							// 'personal_email','if','personal_email','[personal_email]!',
							// 'company_email_id|to_trim|email'
							// 'personal_email|to_trim|email'
							)
					);
		
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave($m){
	}

	function beforeDelete($m){
		// $job_count = $m->ref('xProduction/JobCardEmployeeAssociation')->count()->getOne();
		
		// if($job_count ){
		// 	$this->api->js(true)->univ()->errorMessage('Cannot Delete,first delete Job card')->execute();	
		// }
	}	

	function makeUser($user_id){

		if($user_id == null or $user_id < 0)
			return;
		if(!$this->loaded())
			return;

		//Check for this user is already assigned or not
		$emp = $this->add('xHR/Model_Employee');
		$emp->addCondition('user_id', $user_id);
		$emp->addCondition('id','<>',$this['id']);
		$emp->tryLoadAny();
		if($emp->loaded())
			throw $this->exception('User Already Assigned','Growl');
		
		$this['user_id'] = $user_id;
		$this->save();
	}

	function department(){
		return $this->ref('department_id');
	}

	function post(){
		return $this->ref('post_id');
	}
	function user(){
		return $this->ref('user_id');
	}

	function myJobCards($status){
		$job_cards = $this->add('xProduction/Model_JobCard');
		$assign_j = $job_cards->join('xproduction_jobcard_emp_asso.jobcard_id');
		$assign_j->addField('employee_id');

		$job_cards->addCondition('employee_id',$this->id);
		$job_cards->addCondition('status',$status);

		return $job_cards;
	}

	function assignedJobCards(){
		return $this->myJobCards('assigned');
	}

	function processingJobCards(){
		return $this->myJobCards('processing');
	}

	function processedJobCards(){
		return $this->myJobCards('processed');
	}

	function loadFromLogin(){
		$this->addCondition('user_id',$this->api->auth->model->id);
		$this->tryLoadAny();
		return $this;
	}

	function removeAllSalary(){
		$salary=$this->ref('xHR/Salary')->deleteAll();
		return $this;

	}

	function addSalary($salary_type,$amount){
		$emp_sal = $this->add('xHR/Model_Salary');
		$emp_sal['employee_id'] = $this->id;
		$emp_sal['salary_type_id'] = $salary_type->id;
		$emp_sal['amount'] = $amount;
		$emp_sal->save();
	}


	function getSubordinats(){
		
		$emp_ids = $this->add('xHR/Model_Employee')->addCondition('post_id',$this->post()->getDescendants())->_dsql()->del('fields')->field('id')->getAll();
		$emp_ids = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($emp_ids)),false);
		return $emp_ids;
	}

	function getColleagues(){
		$emp_ids = $this->add('xHR/Model_Employee')->addCondition('post_id',$this['post_id'])->_dsql()->del('fields')->field('id')->getAll();
		$emp_ids = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($emp_ids)),false);
		return $emp_ids;
	}
	
	function createAssociationWithTeam($team){
		if(!$this->loaded() and $item > 0)
			throw new \Exception("Employee Model Must be Loaded");

		$asso_model = $this->add('xProduction/Model_EmployeeTeamAssociation');
		$asso_model->addCondition('employee_id', $this['id']);
		$asso_model->addCondition('team_id', $team);
		$asso_model->tryLoadAny();
		
		$asso_model['is_active'] = true;
		$asso_model->save();

	
	}

}