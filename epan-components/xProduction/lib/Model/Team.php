<?php

namespace xProduction;
class Model_Team extends \Model_Table{
	public $table="xproduction_teams";

	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);

		$this->hasOne('xHR/Department','department_id')->sortable(true);
		$this->addField('name')->sortable(true);
		$this->hasMany('xProduction/EmployeeTeamAssociation','team_id');
		$this->addHook('beforeDelete',$this);
		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		$this->ref('xProduction/EmployeeTeamAssociation')->each(function($m){
			$m->forceDelete();
		});
	}

	function getAssociatedEmployees($team_leader=false){
		if(!$this->loaded())
			throw new \Exception("team Model Must be Loaded",'Employee Association');
			
		$associated_emp = $this->ref('xProduction/EmployeeTeamAssociation');
		$associated_emp->addCondition('team_id',$this->id);
		
		if($team_leader)
			$associated_emp->addCondition('is_team_leader',true);
			
		$associated_emp = $associated_emp->_dsql()->del('fields')->field('employee_id')->getAll();
		$emps= iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_emp)),false);

		if(!count($emps)) $emps=array(0);

		return $emps;
	}

	function addEmployee($employee){
		$assoc= $this->ref('xProduction/EmployeeTeamAssociation')->addCondition('employee_id',$employee->id);
		$assoc->tryLoadAny();
		if(!$assoc->loaded())
			$assoc->save();
	}

	function removeEmployee($employee){
		$assoc= $this->ref('xProduction/EmployeeTeamAssociation')->addCondition('employee_id',$employee->id);
		$assoc->tryLoadAny();
		if($assoc->loaded())
			$assoc->delete();
	}

	function teamLeader(){
		return $this->ref('xProduction/EmployeeTeamAssociation')->tryLoadAny();
	}

}