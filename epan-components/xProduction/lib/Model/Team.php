<?php

namespace xProduction;
class Model_Team extends \Model_Table{
	public $table="xproduction_teams";

	function init(){
		parent::init();
		$this->hasOne('xHR/Department','department_id');
		$this->addField('name');
		$this->hasMany('xProduction/EmployeeTeamAssociation','team_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function getAssociatedEmployees(){
		if(!$this->loaded())
			throw new \Exception("team Model Must be Loaded",'Employee Association');
			
		$associated_emp = $this->ref('xProduction/EmployeeTeamAssociation')->addCondition('team_id',$this->id)->_dsql()->del('fields')->field('employee_id')->getAll();
		return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_emp)),false);
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