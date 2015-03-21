<?php
namespace xHR;
class Model_TemplateSalary extends \Model_Table{
	public $table="xhr_template_salary";
	function init(){
		parent::init();
		$this->hasOne('xHR/SalaryTemplate','salary_template_id')->sortable(true); //kiski
		$this->hasOne('xHR/SalaryType','salary_type_id')->sortable(true)->display(array('form'=>'autocomplete/Plus')); //kiski
		$this->addField('amount')->sortable(true); // 2000 basic, 1500HR ... like this
		
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);

		$this->add('Controller_Validator');
		$this->is(array(
							'amount|to_trim|required',
							)
					);

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){}
	function beforeDelete(){
		if($this->ref('salary_type_id')->count()->getOne() > 0)
			throw $this->exception('Salary  contains of salary Type Please Delete Salary Type First ','Growl');
	}
}