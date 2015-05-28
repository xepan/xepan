<?php
namespace xHR;

class Model_Employee extends \Model_Table{
	public $table="xhr_employees";

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xHR/Post','post_id')->display(array('form'=>'autocomplete/Basic'));
		$this->hasOne('Users','user_id')->display(array('form'=>'autocomplete/Plus'));
		$this->addExpression('username')->set($this->refSQL('user_id')->fieldQuery('username'));
		
		$this->hasOne('xHR/Department','department_id')->display(array('form'=>'autocomplete/Basic'));
		
		//basic Details
		$this->addField('name')->Caption('Full Name')->group('a~5~Basic Info')->sortable(true)->mandatory(true);
		$this->addField('dob')->type('date')->Caption('Date Of Birth')->group('a~3');
		$this->addField('gender')->enum(array('male','female'))->group('a~2')->mandatory(true);
		$this->add('filestore/Field_Image','empolyee_image_id');
		$this->addField('is_active')->type('boolean')->defaultValue(true)->group('a~2');
		

		$this->addExpression('name_with_designation')->set(
			$this->dsql()->concat(
				$this->getElement('name'),
				' / ',
				$this->refSQL('department_id')->fieldQuery('name'),
				' / ',
				$this->refSQL('post_id')->fieldQuery('name')
			)
		);

		//Employment Detail
		
		$this->addField('status')->enum(array('active','left'))->group('b~3~Employment Details')->defaultValue('active')->mandatory(true);
		$this->addField('doj')->type('date')->Caption('Date Of Joining')->group('b~3~bl');
		$this->addField('company_email_id')->group('b~3~bl');
		$this->addField('offer_date')->type('date')->group('b~3');
		$this->addField('confirmation_date')->type('date')->group('b~3');
		$this->addField('contract_end_date')->type('date')->group('b~3');
		$this->addField('date_of_retirement')->type('date')->group('b~3');
		$this->addField('resignation_letter_date')->type('date')->group('b~3');
		$this->addField('seen_till')->system(true);
		// $this->addField('salary_mode')->enum(array('cheque','cash','bank'))->group('b~3');
		// $this->addField('reason_of_resignation')->type('text')->group('b~3');
		// $this->addField('feedback')->type('text')->group('b~3');



		//Contact Detail
		$this->addField('mobile_no')->group('c~3~Contact Detail');
		$this->addField('relation')->group('c~3');
		$this->addField('emergency_contact_person')->group('c~3');
		$this->addField('emergency_contact_no')->type('Number')->group('c~3');
		$this->addField('permanent_addesss')->type('text')->group('c~6');
		$this->addField('current_address')->type('text')->group('c~6');

		
		//personal Detail
		$this->addField('personal_email')->group('d~4~Personal Details');
		$this->addField('passport_no')->group('d~2');
		$this->addField('passport_issue_date')->type('date')->group('d~2');
		$this->addField('passport_expiry_date')->type('date')->group('d~2');
		$this->addField('passport_place_of_issue')->group('d~2');
		$this->addField('blood_group')->group('d~6');
		$this->addField('marital_status')->enum(array('single','married','divorced','widowed'))->group('d~6');//->display(array('form'=>'Radio'));
		$this->addField('family_background')->type('text')->hint('Here You Can Maintain Family Details like name and occuptation of parent , spouse and Children')->group('d~6');
		$this->addField('health_details')->type('text')->hint('Here You can Maintain Height, Weight, allergies, Medicals Concerns etc.')->group('d~6');
		
		


		//qualification Detail
		$this->addField('qualifiction')->group('e~4~Recent Educational Qualification'); 
		$this->addField('qualifiction_level')->enum(array('Graduate','Post Graduate','Under Graduate'))->group('e~4');//->display(array('form'=>'Radio'));
		$this->addField('pass')->Caption('Percent / Division')->group('e~4');
		$this->addField('major_optional_subject')->type('text')->group('e~6');
		
		

		//privious work detail
		$this->addField('previous_work_company')->type('text')->group('f~6~Previous Work Expriences');
		$this->addField('previous_company_address')->type('text')->group('f~6');
		$this->addField('previous_work_designation')->group('f~3');
		$this->addField('from_date')->type('date')->group('f~3');
		$this->addField('previous_company_branch')->group('f~3');
		$this->addField('previous_work_salary')->group('f~3');
		$this->addField('previous_company_department')->group('f~3');
		
		$this->addField('to_date')->type('date')->group('f~3');
		$this->addField('pre_resignation_letter_date')->type('date')->caption('Resignation letter Date')->group('f~3');
		$this->addField('pre_relieving_date')->type('date')->group('f~3');
		$this->addField('pre_reason_of_resignation')->type('text')->caption('Reason of Resignation')->group('f~4');
		
		


		$this->hasMany('xHR/Salary','employee_id');
		// $this->hasMany('xProduction/JobCardEmployeeAssociation','employee_id');
		$this->hasMany('xProduction/EmployeeTeamAssociation','employee_id');
		$this->hasMany('LastSeen','employee_id');
		$this->hasMany('xHR/OfficialEmail','employee_id');
		$this->hasMany('xCRM/Email','read_by_employee_id');
		$this->hasMany('xHR/EmployeeAttendence','employee_id');
		$this->hasMany('xHR/EmployeeLeave','employee_id');
		
		$this->hasMany('xAccount/Account','created_by_id',null,'CreatedAccounts');
		$this->hasMany('xAccount/Transaction','created_by_id',null,'CreatedTransactions');

		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);
		$this->addHook('afterInsert',$this);
		
		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required?type your name here',
							// 'company_email_id|email|unique','if','*','[company_email_id]'
							// 'personal_email','if','personal_email','[personal_email]!',
							// 'company_email_id|to_trim|email'
							// 'personal_email|to_trim|email'
							)
					);
		
		// $this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave($m){
	}

	function beforeDelete($m){
		$accounts = $this->ref('CreatedAccounts')->count()->getOne();
		$salary = $m->ref('xHR/Salary')->count()->getOne();
		$team_asso = $m->ref('xProduction/EmployeeTeamAssociation')->count()->getOne();
		// $last_seen = $m->ref('LastSeen')->count()->getOne();
		$official_email = $m->ref('xHR/OfficialEmail')->count()->getOne();
		$email = $m->ref('xCRM/Email')->count()->getOne();
		
		if($accounts or $salary or $team_asso or $official_email or $email){
			throw $this->exception('Cannot Delete,first delete Salary, Team Association, OfficialEmail or Email','Growl');	
		}


			
	}

	function forceDelete(){
		
		$this->ref('CreatedAccounts')->each(function($m){
			$m->set('employee_id',NULL)->saveAndUnload();
		});

		$this->ref('xHR/Salary')->each(function($p){
			$p->forceDelete();
		});

		$this->ref('xHR/OfficialEmail')->each(function($official_email){
			$official_email->forceDelete();
		});
		
		$this->ref('xCRM/Email')->each(function($email){
			$email->setReadByEmployeeNull();
		});
		
		$this->ref('LastSeen')->each(function($last_seen){
			$last_seen->forceDelete();
		});

		$this->ref('xProduction/EmployeeTeamAssociation')->each(function($team_asso){
			$team_asso->forceDelete();
		});


		$this->ref('xHR/EmployeeAttendence')->each(function($attendance){
			$attendance->forceDelete();
		});

		$this->ref('xHR/EmployeeLeave')->each(function($leave){
			$leave->forceDelete();
		});

		$this->add('Model_LastSeen')->addCondition('employee_id',$this->id)->deleteAll();
		$this->add('xProduction\Model_Task')
			->addCondition('employee_id',$this->id)->each(function($obj){
				$obj->delete();
			});

		// Remove created_by_id from all documents
		$done_documents = array();

		$docs_model=$this->add('xHR/Model_Document');

		$docs= $docs_model->getDefaults();
		foreach ($docs as $doc_junk) {
			$dm = $docs_model->modelName($doc_junk['name']);
			$model = $this->add($dm);
			if(!in_array($model->root_document_name,$done_documents)){
				try{
					$model = $this->add($docs_model->modelName($model->root_document_name));
					if(!(isset($model->is_view) AND $model->is_view)){
						$model->_dsql()->where('created_by_id',$this->id)->where('epan_id',$this->api->current_website->id)->set('created_by_id',null)->update();
					}
				}catch(\Exception $e){
					echo "Model Employee Line 186 Error: ".$model->root_document_name .'<br/>'.$e->getHTML()."<br>";
				}
				$done_documents[] = $model->root_document_name;
			}else{
				continue;
			}

		}
		$this->api->db->dsql()->table('attachments')->where('created_by_id',$this->id)->where('epan_id',$this->api->current_website->id)->set('created_by_id',null)->update();
		
		$this->delete();
	}

	function totalPresent(){
		return $this->ref('xHR/EmployeeAttendence')->addCondition('status','present')->count()->getOne();
	}	
	function afterInsert($obj,$new_id){		
		$employee_model=$this->add('xHR/Model_Employee')->load($new_id);
		$employee_model_value = array($employee_model);
		$this->api->event('new_employee_registered',$employee_model_value);
	}

	function markPresent($date){
		$emp_att=$this->add('xHR/Model_EmployeeAttendence');
		$emp_att->addCondition('date',$date);
		$emp_att->addCondition('employee_id',$this['id']);
		$emp_att->tryLoadAny();
		$emp_att['status']='present';
		$emp_att->save();
	}

	function markAbsent($date){
		$emp_att=$this->add('xHR/Model_EmployeeAttendence');
		$emp_att->addCondition('date',$date);
		$emp_att->addCondition('employee_id',$this['id']);
		$emp_att->tryLoadAny();
		$emp_att['status']='absent';
		$emp_att->save();	
	}
	function markHalfDay($date){
		$emp_att=$this->add('xHR/Model_EmployeeAttendence');
		$emp_att->addCondition('date',$date);
		$emp_att->addCondition('employee_id',$this['id']);
		$emp_att->tryLoadAny();
		$emp_att['status']='half_day';
		$emp_att->save();	
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

	function getTeams(){
		$teams_ids = $this->add('xProduction/Model_EmployeeTeamAssociation')->addCondition('employee_id',$this->id)->_dsql()->del('fields')->field('team_id')->getAll();
		$teams_ids = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($teams_ids)),false);
		if(!count($teams_ids)) $teams_ids=array(0);
		return $teams_ids;
	}

	function myJobCards($status){
		$team_ids= $this->getTeams();

		$job_cards = $this->add('xProduction/Model_Jobcard_'.ucwords($status));
		$assign_j = $job_cards->join('xproduction_document_assignments.document_id');
		$assign_j->addField('employee_id');
		$assign_j->addField('team_id');

		$job_cards->addCondition(
			$this->dsql()->orExpr()
			->where('employee_id',$this->id)
			->where('team_id',$team_ids)
			);
		
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


	function email(){
		if(!$this->loaded())
			return false;
		return $this['personal_email'];
	}

	function mobileno(){
		if(!$this->loaded())
			return false;
		return $this['mobile_no'];	
	}

	function updateEmail($email){
		if(!$this->loaded()) return false;
		
		$this['personal_email'] = $this['personal_email'].', '.$email;
		$this->save();
	}

	function deactivate(){
		if(!$this->loaded())
			return false;
		
		$this['is_active'] = false;
		$this->save();
		return true;
	}
}