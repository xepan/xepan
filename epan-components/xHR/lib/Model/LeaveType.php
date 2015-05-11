<?php

namespace xHR;
class Model_LeaveType extends \Model_Table{
	public $table="xhr_leave_types";
	function init(){
		parent::init();

		$this->hasOne('Epan','epan_id');
		$this->addCondition('epan_id',$this->api->current_website->id);
		
		$this->addField('name')->caption('Leave Type');
		$this->addField('max_day_allow')->type('int');
		$this->addField('is_carry_forward')->type('boolean');
		$this->addField('is_lwp')->type('boolean');
		$this->addField('allow_negative_balance')->type('boolean');

		$this->hasMany('xHR/EmployeeLeave','leave_type_id');

		//$this->add('dynamic_model/Controller_AutoCreator');
	}
}