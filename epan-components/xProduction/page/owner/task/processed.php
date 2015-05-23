<?php

class page_xProduction_page_owner_task_processed extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();

		$col=$this->add('Columns');
		$left_col=$col->addColumn(6);
		$right_col=$col->addColumn(6);
		$left_col->add('View_Info')->set('Processed By Me');
		$mytask = $left_col->add('xProduction/Model_Task_Processed');
		$mytask->addCondition('employee_id',$this->api->current_employee->id);
		
		$crud=$left_col->add('CRUD',array('allow_add'=>false,'allow_edit'=>false,'allow_del'=>false,'grid_class'=>'xProduction/Grid_Task'));
		$crud->setModel($mytask);
			$crud->manageAction('see_activities');

		// $crud->add('xHR/Controller_Acl');

		$right_col->add('View_Info')->set('Processed By Employee');
		$emptask = $right_col->add('xProduction/Model_Task_Processed');
		$emptask->addCondition('created_by_id',$this->api->current_employee->id);
		$crud=$right_col->add('CRUD',array('allow_add'=>false,'allow_edit'=>false,'allow_del'=>false,'grid_class'=>'xProduction/Grid_Task'));
		$crud->setModel($emptask);
		$crud->manageAction('approve');
			$crud->manageAction('see_activities');
			$crud->manageAction('cancel');
		// $crud->add('xHR/Controller_Acl');
	}
}