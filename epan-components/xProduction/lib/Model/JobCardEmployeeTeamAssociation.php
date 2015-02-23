<?php

namespace xProduction;

class Model_JobCardEmployeeTeamAssociation extends \SQL_Model{
	public $table ="xproduction_jobcard_emp_team_asso";

	function init(){
		parent::init();

		$this->hasOne('xProduction/Model_JobCard','jobcard_id');
		$this->hasOne('xHR/Model_Employee','employee_id');
		$this->hasOne('xProduction/Model_Team','team_id');
		
		$this->add('dynamic_model/Controller_AutoCreator');

	}
}	