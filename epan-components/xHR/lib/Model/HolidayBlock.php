<?php
namespace xHR;

class Model_HolidayBlock extends \Model_Table{
	public $table="xhr_holiday_blocks";
	function init(){
		parent::init();
		$this->hasOne('xHR/Model_Department','department_id');

		$this->addField('name');
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