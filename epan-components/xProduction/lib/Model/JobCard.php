<?php

namespace xProduction;

class Model_JobCard extends \SQL_Model{
	public $table ="xproduction_jobcard";

	function init(){
		parent::init();
		// hasOne OrderItemDepartment Association id
		$this->hasOne('xShop/OrderDetails','orderitem_id');
		$this->hasOne('xHR/Department','department_id');
		$this->hasOne('xShop/OrderItemDepartmentalStatus','orderitem_departmental_status_id');

		$this->hasOne('xHR/Employee','created_by_id')->defaultValue($this->api->current_employee->id)->system(true);
		
		$this->addField('name')->caption('Job Number');
		$this->addField('status')->enum(array('-','received','approved','assigned','processing','processed','completed','forwarded'))->defaultValue('-');

		$this->hasMany('xProduction/JobCardEmployeeAssociation','jobcard_id');

		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required',
							)
					);
		$this->add('dynamic_model/Controller_AutoCreator');

	}

	function assignTo($employee){
		// create log/communication 
		$temp=$this->add('xProduction/Model_JobCardEmployeeAssociation');
		$temp->addCondition('jobcard_id',$this->id);
		$temp->addCondition('employee_id',$employee->id);
		$temp->tryLoadAny();
		$temp->save();

		$this['status']='assigned';
		$this->saveAs('xProduction/Model_JobCard');
		// throw $this->exception('To Do');
	}

	function getAssociatedEmployees(){
		$associate_employees= $this->ref('xProduction/JobCardEmployeeAssociation')->_dsql()->del('fields')->field('employee_id')->getAll();
		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associate_employees)),false);
	}

	function removeAllEmployees(){
		$this->ref('xProduction/JobCardEmployeeAssociation')->deleteAll();
		$this['status']='received'; // back to received .. not assigned
		$this->saveAs('xProduction/Model_JobCard');
	}

	function previousDeptJobCard(){
		if($pre_dept = $this->dept()->previousDepartment()){
			$pre_dept_job_card = $this->newInstance();
			$pre_dept_job_card->addCondition('orderitem_id',$this['orderitem_id']);
			$pre_dept_job_card->addCondition('department_id',$pre_dept->id);
			$pre_dept_job_card->tryLoadAny();

			if($pre_dept_job_card->loaded()) return $pre_dept_job_card;
		}
		return false;
	}

	function dept(){
		return $this->ref('department_id');
	}

	function receive(){
		// mark complete previous dept jobcard
		if($pre_dept_job_card = $this->previousDeptJobCard()){
			$pre_dept_job_card->complete();
		}
		// self status received
		$this['status']='received';
		$this['created_by_id']=$this->api->current_employee->id;
		
		$this->saveAs('xProduction/Model_JobCard');
	}

	function complete(){
		$this['status']='completed';
		$this->saveAs('xProduction/Model_JobCard');
	}
}	