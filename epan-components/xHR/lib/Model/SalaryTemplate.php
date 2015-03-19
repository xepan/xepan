<?php
namespace xHR;

class Model_SalaryTemplate extends \Model_Table{
	public $table="xhr_salary_templates";
	function init(){
		parent::init();
		$this->hasOne('xHR/Department','department_id')->mandatory(true)->sortable(true);
		$this->hasOne('xHR/Post','post_id')->mandatory(true)->sortable(true);

		$this->addField('name')->mandatory(true)->sortable(true); // Marketing Manager salary 
		
		$this->hasMany('xHR/TemplateSalary','salary_template_id');
		
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);

		// $this->add('Controller_Validator');
		// $this->is(array(
							// 'name|to_trim|required',
							// )
					// );

		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){}
	function beforeDelete(){
		if($this->ref('xHR/TemplateSalary')->count()->getOne() > 0)
			throw $this->exception('Templates contains salary','Growl');
	}
}