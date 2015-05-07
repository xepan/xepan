<?php

class page_xProduction_page_owner_task_rejected extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		$task_model = $this->add('xProduction/Model_Task_Rejected');

		$task_model->addCondition(
				$task_model->dsql()->orExpr()
				->where('created_by_id',$this->api->current_employee->id)
				->where('employee_id',$this->api->current_employee->id));

		$crud=$this->add('CRUD',array('allow_add'=>false,'allow_edit'=>true,'allow_del'=>false,'grid_class'=>'xProduction/Grid_Task'));
		$crud->setModel($task_model);
		// $crud->add('xHR/Controller_Acl');

		
	}
}