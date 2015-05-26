<?php
namespace xProduction;

class Model_Task_Completed extends Model_Task{
	public $actions=array(
			'can_view'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','completed');
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

		return "<span class='label label-success' title='Tasks Completed By Me'>$count_my</span>/<span class='label label-success' title='My Given Tasks Completed'>$count_given_by_my</span>";
	}
}