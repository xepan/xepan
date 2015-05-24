<?php
namespace xProduction;

class Model_Task_Draft extends Model_Task{
	public $actions=array(
			'can_view'=>array(),
			'can_start_processing'=>array(),
			'can_mark_processed'=>array(),
			'can_reject'=>array(),
			'can_assign'=>array()
		);
	function init(){
		parent::init();

		$this->addCondition('status','draft');
	}

	function myCounts(){
		$count = $this->addCondition(
				$this->dsql()->orExpr()
					->where('created_by_id',$this->api->current_employee->id)
					->where('employee_id',$this->api->current_employee->id)
			)
		->count()->getOne();

		return "<span class='label label-danger' title='My Pending Tasks' >$count</span>";
	}
}