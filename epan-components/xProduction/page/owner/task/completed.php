<?php

class page_xProduction_page_owner_task_completed extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		
		$col=$this->add('Columns');
		$left_col=$col->addColumn(6);
		$right_col=$col->addColumn(6);
		$left_col->add('View_Info')->set('Completed By Me');
		$mytask = $left_col->add('xProduction/Model_Task_Completed');
		$mytask->addCondition('employee_id',$this->api->current_employee->id);
		
		$crud=$left_col->add('CRUD');
		$crud->setModel($mytask);

		$crud->add('xHR/Controller_Acl');

		$right_col->add('View_Info')->set('Completed By Employee');
		$emptask = $right_col->add('xProduction/Model_Task_Completed');
		$emptask->addCondition('created_by_id',$this->api->current_employee->id);
		$crud=$right_col->add('CRUD');
		$crud->setModel($emptask);

		$crud->add('xHR/Controller_Acl');

	}
}