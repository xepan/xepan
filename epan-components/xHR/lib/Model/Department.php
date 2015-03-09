<?php
namespace xHR;

class Model_Department extends \Model_Table{
	public $table="xhr_departments";
	function init(){
		parent::init();
		

		$this->hasOne('Branch','branch_id');
		//$this->hasOne('xHR/Department','previous_department_id')->defaultValue('0');
		
		$this->addField('production_level')->type('int')->mandatory(true);
		$this->addField('name')->Caption('Department')->mandatory(true);
	
		$this->addField('proceed_after_previous_department')->type('boolean')->group('a~4~Department Attributes');
		$this->addField('internal_approved')->type('boolean')->group('a~4');
		$this->addField('acl_approved')->type('boolean')->group('a~4');
		$this->addField('jobcard_assign_required')->type('boolean')->group('a~4');
		$this->addField('is_production_department')->type('boolean')->defaultValue(true)->group('a~4');
		$this->addField('is_system')->type('boolean')->defaultValue(false)->group('a~2');
		$this->addField('is_active')->type('boolean')->defaultValue(true)->group('a~2');
		$this->addField('is_outsourced')->type('boolean')->defaultValue(false)->group('a~4');
		
		$this->addField('jobcard_document')->defaultValue('JobCard')->system(true);
		
		$this->addField('related_application_namespace')->defaultValue('xProduction')->group('a~4');
		
		// $this->hasMany('xHR/Department','previous_department_id');
		$this->hasMany('xHR/Post','department_id');
		$this->hasMany('xHR/Employee','department_id');
		$this->hasMany('xHR/HolidayBlock','department_id');
		$this->hasMany('xShop/ItemDepartmentAssociation','department_id');
		$this->hasMany('xHR/Document','department_id');
		$this->hasMany('xProduction/Team','department_id');
		// $this->hasMany('xProduction/OutSourceParty','department_id');
		$this->hasMany('xProduction/OutSourcePartyDeptAssociation','department_id');
		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required?Must be type Department here',
							'production_level!|int|>=0|<999?Must be a number between 0 and 999'
							)
					);
		
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function getNamespace(){
		return $this['related_application_namespace'];
	}

	function jobcard_document(){
		return $this['jobcard_document'];
	}

	function beforeSave($m){
		// todo checking SKU value must be unique
		$dept_old=$this->add('xHR/Model_Department');
		if($this->loaded())
			$dept_old->addCondition('id','<>',$this->id);
		$dept_old->tryLoadAny();

		if($dept_old['name'] == $this['name'])
			throw $this->exception('Department is Allready Exist','Growl')->setField('name');
	}

	function beforeDelete($m){
		$post_count = $m->ref('xHR/Post')->count()->getOne();
		$emp_count = $m->ref('xHR/Employee')->count()->getOne();
		
		if($post_count or $emp_count){
			$this->api->js(true)->univ()->errorMessage('Cannot Delete,first delete Post or Employees')->execute();	
		}
	}

	function createAssociationWithItem($item_id){
		if(!$this->loaded() and $item_id > 0)
			throw new \Exception("Department Model Must be Loaded");

		$asso_model = $this->add('xShop/Model_ItemDepartmentAssociation');
		$asso_model->addCondition('department_id', $this['id']);
		$asso_model->addCondition('item_id', $item_id);
		$asso_model->tryLoadAny();
		
		$asso_model['is_active'] = true;
		$asso_model->save();

	}

	function employees(){
		return $this->ref('xHR/Employee');
	}

	function staffs(){
		return $this->employees();
	}

	function documents(){
		return $this->ref('xHR/Document');
	}

	function teams(){
		return $this->ref('xProduction/Team');
	}

	function isOutSourced(){
		return $this['is_outsourced'];
	}

	function outSourceParties(){
		return $this->add('xProduction/Model_OutSourceParty')->addCondition('id',$this->getAssociatedOutsourceParty());
	}

	function previousDepartment(){
		if($this['previous_department_id'])
			return $this->ref('previous_department_id');
		else
			return false;
	}

	function getAssociatedOutsourceParty(){
		$associated_parties = $this->ref('xProduction/OutSourcePartyDeptAssociation')->_dsql()->del('fields')->field('out_source_party_id')->getAll();
		
		$array =  iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_parties)),false);

		if(!count($array)) $array = array(0);
		return $array;
	}

	function associatedOutsourceParties(){
		return $this->add('xProduction/Model_OutSourceParty')->addCondition('id',$this->getAssociatedOutsourceParty());
	}

	function addOutSourceParty($party){
		$outsource_assos_model=$this->add('xProduction/Model_OutSourcePartyDeptAssociation');
		$outsource_assos_model->addCondition('department_id',$this->id);
		$outsource_assos_model->addCondition('out_source_party_id',$party->id);
		$outsource_assos_model->tryLoadAny();
		if(!$outsource_assos_model->loaded()) $outsource_assos_model->save();

		$party->warehouse();

		return $outsource_assos_model;
	}

	function removeOutSourceParty($party){
		$outsource_assos_model=$this->add('xProduction/Model_OutSourcePartyDeptAssociation');
		$outsource_assos_model->addCondition('department_id',$this->id);
		$outsource_assos_model->addCondition('out_source_party_id',$party->id);
		$outsource_assos_model->tryLoadAny();
		if($outsource_assos_model->loaded()) $outsource_assos_model->delete();

		if($party->getAssociatedDepartments() === array(0)) $party->warehouse()->deleteIfOK();

	}


	function loadHR(){
		if($this->loaded())
			$this->unload();
		$temp = $this->add('xHR/Model_Department');
		$temp->addCondition('name','HR')->loadAny();
		$this->load($temp->id);
		return $this;
	}

	function isHR(){
		return $this['name'] =='HR';
	}

	function loadMarketing(){
		if($this->loaded())
			$this->unload();
		$temp = $this->add('xHR/Model_Department');
		$temp->addCondition('name','Marketing')->loadAny();
		$this->load($temp->id);
		return $this;
	}

	function isMarketing(){
		return $this['name'] =='Marketing';
	}

	function loadSales(){
		if($this->loaded())
			$this->unload();
		$temp = $this->add('xHR/Model_Department');
		$temp->addCondition('name','Sales')->loadAny();
		$this->load($temp->id);
		return $this;
	}

	function isSales(){
		return $this['name'] =='Sales';
	}

	function loadProduction(){
		if($this->loaded())
			$this->unload();
		$temp = $this->add('xHR/Model_Department');
		$temp->addCondition('name','Production')->loadAny();
		$this->load($temp->id);
		return $this;
	}

	function isProduction(){
		return $this['name'] =='Production';
	}

	function loadCRM(){
		if($this->loaded())
			$this->unload();
		$temp = $this->add('xHR/Model_Department');
		$temp->addCondition('name','CRM')->loadAny();
		$this->load($temp->id);
		return $this;
	}

	function isCRM(){
		return $this['name'] =='CRM';
	}

	function loadAccounts(){
		if($this->loaded())
			$this->unload();
		$temp = $this->add('xHR/Model_Department');
		$temp->addCondition('name','Accounts')->loadAny();
		$this->load($temp->id);
		return $this;
	}

	function isAccounts(){
		return $this['name'] =='Accounts';
	}
	
	function loadPurchase(){
		if($this->loaded())
			$this->unload();
		$temp = $this->add('xHR/Model_Department');
		$temp->addCondition('name','Purchase')->loadAny();
		$this->load($temp->id);
		return $this;
	}

	function isPurchase(){
		return $this['name'] =='Purchase';
	}

	function loadStore(){
		if($this->loaded())
			$this->unload();
		$temp = $this->add('xHR/Model_Department');
		$temp->addCondition('name','Store')->loadAny();
		$this->load($temp->id);
		return $this;
	}

	function isStore(){
		return $this['name'] =='Store';
	}

	function loadDispatch(){
		if($this->loaded())
			$this->unload();
		$temp = $this->add('xHR/Model_Department');
		$temp->addCondition('name','Dispatch And Delivery')->loadAny();
		$this->load($temp->id);
		return $this;
	}

	function isDispatch(){
		return $this['name'] =='Dispatch And Delivery';
	}

	function warehouse(){
		$w=$this->add('xStore/Model_Warehouse');
		$w->addCondition('department_id',$this->id);
		$w->tryLoadAny();
		if(!$w->loaded()){
			$w['name']=$this['name'];
			$w->save();
		}

		return $w;
	}

}