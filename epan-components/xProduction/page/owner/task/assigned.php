<?php

class page_xProduction_page_owner_task_assigned extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		
		$col=$this->add('Columns');
		// $left_col=$col->addColumn(6);
		$right_col=$col->addColumn(12);
		
		// $left_col->add('View_Info')->set('Assign To Me');
		// $assign_to_me_task = $left_col->add('xProduction/Model_Task_Assigned');
		// $assign_to_me_task->addCondition('employee_id',$this->api->current_employee->id);
		// $left_crud=$left_col->add('CRUD',array('grid_class'=>'xProduction/Grid_Task'));
		// $left_crud->setModel($assign_to_me_task);
		// $left_crud->add('xHR/Controller_Acl');

		$right_col->add('View_Info')->set('Assign By Me');
		$assign_by_me_task = $right_col->add('xProduction/Model_Task_Assigned');
		$assign_by_me_task->addCondition('created_by_id',$this->api->current_employee->id);
		$crud=$right_col->add('CRUD',array('allow_add'=>false,'allow_edit'=>false,'allow_del'=>false,'grid_class'=>'xProduction/Grid_Task'));
		$crud->setModel($assign_by_me_task);
		$crud->manageAction('cancel');
		$crud->manageAction('activities');
		// $crud->add('xHR/Controller_Acl');

		
	}
}