<?php
namespace xHR;

class Model_HolidayBlock extends \Model_Table{
	public $table="xhr_holiday_blocks";
	function init(){
		parent::init();
		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->hasOne('xHR/Model_Department','department_id')->sortable(true);

		$this->addField('name')->sortable(true);
		$this->addHook('beforeSave',$this);
		$this->addHook('beforeDelete',$this);

		$this->add('Controller_Validator');
		$this->is(array(
							'name|to_trim|required',
							)
					);
		//$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){}
	function beforeDelete(){}
}