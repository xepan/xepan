<?php

class Model_Document_DepartmentDocument extends Model_GenericDocument {
	public $actions=array(
		'allow_add'=>array(),
		'allow_edit'=>array(),
		'allow_del'=>array(),
		);

	function init(){
		parent::init();
		$this->addCondition('status','departmental');
		$this->addExpression('department_id')->set($this->refSQL('created_by_id')->fieldQuery('department_id'));
		
		$this->addCondition('department_id',@$this->api->current_employee['department_id']);		
	}
}