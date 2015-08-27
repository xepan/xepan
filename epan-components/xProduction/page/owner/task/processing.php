<?php

class page_xProduction_page_owner_task_processing extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();

		$col=$this->add('Columns');
		$left_col=$col->addColumn(6);
		$right_col=$col->addColumn(6);
		$left_col->add('View_Info')->set('Processing By Me');
		$mytask = $left_col->add('xProduction/Model_Task_Processing');
		$mytask->addCondition('employee_id',$this->api->current_employee->id);
		
		$crud=$left_col->add('CRUD',array('allow_add'=>false,'allow_edit'=>false,'allow_del'=>false,'grid_class'=>'xProduction/Grid_Task'));
		$crud->setModel($mytask);
		$crud->manageAction('mark_processed','ok atk-swatch-green');
		$crud->manageAction('reject','cancel-circled atk-swatch-red');
		$crud->manageAction('activities','comment atk-swatch-blue');
		// $crud->add('xHR/Controller_Acl');

		$right_col->add('View_Info')->set('Processing By Employee');
		$emptask = $right_col->add('xProduction/Model_Task_Processing');
		$emptask->addCondition('created_by_id',$this->api->current_employee->id);
		$crud=$right_col->add('CRUD',array('allow_add'=>false,'allow_edit'=>false,'allow_del'=>false,'grid_class'=>'xProduction/Grid_Task'));
		$crud->setModel($emptask);
		$crud->manageAction('activities','comment atk-swatch-blue');
		// $crud->add('xHR/Controller_Acl');
	}
}