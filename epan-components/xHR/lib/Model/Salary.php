<?php
namespace xHR;

class Model_Salary extends \Model_Table{
	public $table="xhr_salary";
	function init(){
		parent::init();
		$this->hasOne('xHR/Employee','employee_id'); //kiski
		
		$this->hasOne('xHR/SalaryType','salary_type_id'); // basic, DA, HRA etc
		$this->addField('amount'); // 2000 basic, 1500HR ... like this
		
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);
		$this->hasOne('xHR/Employee','created_by_id')->defaultValue($this->api->current_employee->id)->system(true);
		$this->add('Controller_Validator');
		$this->is(array(
							'amount|to_trim|required',
							)
					);
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){}
	function beforeDelete(){}
}