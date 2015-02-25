<?php
namespace xProduction;
class Model_EmployeeTeamAssociation extends \Model_Table{
	public $table="xproduction_employee_team_associations";
	function init(){
		parent::init();

		$this->hasOne('xProduction/Team','team_id');
		$this->hasOne('xHR/Employee','employee_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}

}