<?php
namespace xHR;

class Model_Department extends \Model_Table{
	public $table="xhr_departments";
	function init(){
		parent::init();
		

		$this->hasOne('Branch','branch_id');
		$this->hasOne('xHR/Department','previous_department_id')->defaultValue('0');
		
		$this->addField('name')->Caption('Department');
	
		$this->addField('proceed_after_previous_department')->type('boolean');
		$this->addField('internal_approved')->type('boolean');
		$this->addField('acl_approved')->type('boolean');
		$this->addField('jobcard_assign_required')->type('boolean');
		$this->addField('is_production_department')->type('boolean')->defaultValue(false);
		$this->addField('is_active')->type('boolean')->defaultValue(true);
		
		$this->addField('related_application_namespace')->defaultValue('xProduction');
		
		$this->hasMany('xHR/Department','previous_department_id');
		$this->hasMany('xHR/Post','department_id');
		$this->hasMany('xHR/Employee','department_id');
		$this->hasMany('xHR/HolidayBlock','department_id');
		$this->hasMany('xShop/ItemDepartmentAssociation','department_id');
		$this->hasMany('xHR/Document','department_id');
		$this->hasMany('xProduction/Team','department_id');
		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required?Must be type Department here'
							)
					);
		
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);

		// $this->add('dynamic_model/Controller_AutoCreator');
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

	function previousDepartment(){
		if($this['previous_department_id'])
			return $this->ref('previous_department_id');
		else
			return false;
	}

}