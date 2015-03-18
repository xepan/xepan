<?php
namespace xHR;

class Model_SalaryType extends \Model_Table{
	public $table="xhr_salary_types";
	function init(){
		parent::init();
		$this->hasOne('xHR/SalaryTemplate','salary_template_id');

		$this->addField('name');
		
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);
		$this->hasMany('xHR/Salary','salary_type_id');

		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required',
							)
					);

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){}
	function beforeDelete(){
		$tem_salary=$this->ref('salary_template_id')->count()->getOne() > 0;
		$salary=$this->ref('xHR/Salary')->count()->getOne() > 0;
		if($tem_salary OR $salary)
			throw $this->exception('Salary Type contains O  Templates. Please Delete Templates First','Growl');
	}
}