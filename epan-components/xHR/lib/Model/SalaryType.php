<?php
namespace xHR;

class Model_SalaryType extends \Model_Table{
	public $table="xhr_salary_types";
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->addField('name')->sortable(true);
		
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);
		$this->hasMany('xHR/Salary','salary_type_id');

		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required',
							)
					);
		$this->hasMany('xHR/TemplateSalary','salary_type_id');

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){}
	function beforeDelete(){
		$tem_salary = $this->ref('xHR/TemplateSalary')->count()->getOne();
		$salary=$this->ref('xHR/Salary')->count()->getOne();

		if($tem_salary OR $salary)
			throw $this->exception("Salary Type is Used in Salary Templates($tem_salary) or Salaries($salary). Please Remove its use first",'Growl');
	}

	function forceDelete(){
		$this->ref('xHR/TemplateSalary')->each(function($TemplateSalary){
			$TemplateSalary->forceDelete();
		});
	}
}