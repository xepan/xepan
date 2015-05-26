<?php
namespace xProduction;
class Model_Task_Processing extends Model_Task{
	public $actions=array(
			'can_view'=>array(),
			// 'can_reject'=>array(),
			'can_mark_processed'=>array('icon'=>'ok'),
		);
	function init(){
		parent::init();

		$this->addCondition('status','processing');
	}

	function myCounts(){
		$count_my = $this->newInstance()
				->addCondition('status',$this['status'])
				->addCondition('employee_id',$this->api->current_employee->id)
				->count()->getOne();

		$count_given_by_my = $this->newInstance()
				->addCondition('status',$this['status'])
				->addCondition('created_by_id',$this->api->current_employee->id)
				->count()->getOne();

		return "<span class='label label-warning' title='My Tasks Under-Process'>$count_my</span>/<span class='label label-warning' title='Under-Process Tasks Given By Me'>$count_given_by_my</span>";
	}
}