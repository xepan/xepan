<?php
namespace xHR;

class Model_SalaryTemplate extends \Model_Table{
	public $table="xhr_salary_templates";
	function init(){
		parent::init();
		$this->hasOne('xHR/Department','department_id');
		$this->hasOne('xHR/Post','post_id');

		$this->addField('name'); // Marketing Manager salary 
		
		$this->hasMany('xHR/TemplateSalary','salary_template_id');
		
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);

		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required',
							)
					);

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){}
	function beforeDelete(){}
}