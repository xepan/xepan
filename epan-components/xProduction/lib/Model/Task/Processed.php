<?php
namespace xProduction;
class Model_Task_Processed extends Model_Task{
	public $actions=array(
			'can_view'=>array(),
			'can_approve'=>array(),
			'can_see_activities'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','processed');
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

		return "<span class='label label-warning' title='My Processed Tasks, Assigner will approve now'>$count_my</span>/<span class='label label-danger' title='Tasks Processed Given By Me, Approve/Reject/Cancel'>$count_given_by_my</span>";
	}
}