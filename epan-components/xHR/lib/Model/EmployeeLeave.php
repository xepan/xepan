<?php
namespace xHR;

class Model_EmployeeLeave extends \Model_Table{
	public $table="xhr_employee_leave";
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->addExpression('department')->set(function($m,$q){
			return $m->refSQL('employee_id')->fieldQuery('department');
		})->sortable(true);

		$this->addExpression('post')->set(function($m,$q){
			return $m->refSQL('employee_id')->fieldQuery('post');
		})->sortable(true);
		
		$this->hasOne('xHR/Employee','employee_id');
		$this->hasOne('xHR/LeaveType','leave_type_id');
		$this->addField('from_date')->type('date');
		$this->addField('to_date')->type('date');
		$this->addField('reason')->type('text');
		$this->addField('half_day')->type('boolean');

		$this->addExpression('total_leave')->set('"TODOO"');
		// $this->addExpression('total_leave')->set(function($m,$q){
		// 	return ('DATEDIFF("'.$m['from_date'].'","'.$m['to_date'].'")');
		// })->sortable(true);

		// $this->add('dynamic_model/Controller_AutoCreator');

	}
}