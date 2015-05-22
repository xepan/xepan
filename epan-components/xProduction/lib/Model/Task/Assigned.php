<?php
namespace xProduction;

class Model_Task_Assigned extends Model_Task{
	public $actions=array(
			'can_view'=>array(),
			'can_reject'=>array(),
			'can_start_processing'=>array(),
		);
	function init(){
		parent::init();

		$this->addCondition('status','assigned');
	}
	function myCounts(){
		$count = $this->addCondition(
				$this->dsql()->orExpr()
					->where('created_by_id',$this->api->current_employee->id)
					// ->where('employee_id',$this->api->current_employee->id)
			)
		->count()->getOne();

		return "<span class='label label-danger' title='Tasks Assigned By Me, Pending by assignee to act'>$count</span>";
	}
}