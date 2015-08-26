<?php

class page_xProduction_page_owner_task_shortmenu extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		
		$column = $this->add('Columns');
		$left_col = $column->addColumn(4);
		$middle_col = $column->addColumn(4);
		$right_col = $column->addColumn(4);

		//Pending Task
		$left_col->add('View_Hint')->set('Pending Task-Assing To Me');
		$assign_to_me_task = $left_col->add('xProduction/Model_Task_Assigned');
		$assign_to_me_task->addCondition('employee_id',$this->api->current_employee->id);
		$assign_to_me_crud=$left_col->add('CRUD',array('allow_add'=>false,'allow_edit'=>false,'allow_del'=>false,'grid_class'=>'xProduction/Grid_Task','ipp'=>1));
		$assign_to_me_crud->setModel($assign_to_me_task);
		$assign_to_me_crud->manageAction('start_processing');
		$assign_to_me_crud->manageAction('reject');
		$assign_to_me_crud->manageAction('activities');
		// $left_col->

		//TODO CREATE AND ASSIGN TASK
		$middle_col->add('View_Hint')->set('TODO/Notes Create Task');
		$form = $middle_col->add('Form_Stacked');
		$form->addField('line','subject')->validateNotNull();
		$form->addField('text','content');
		$form->addField('dropdown','priority')->setValueList(array('Low'=>'Low','Medium'=>'Medium','High'=>'High','Urgent'=>'Urgent'))->set('Medium');
		$form->addField('autocomplete/Basic','assign_to_employee')->setModel('xHR/Model_Employee');
		$form->addField('DatePicker','expected_end_date')->setModel('xHR/Model_Employee');
		$form->addSubmit('Create Task');

		$form->onSubmit(function($form){
			$draft = $form->add('xProduction/Model_Task_Draft');
			$draft->addCondition('created_by_id',$this->api->current_employee->id);
			$draft['subject'] = $form['subject'];
			$draft['content'] = $form['content'];
			$draft['priority'] = $form['priority'];
			$draft['expected_end_date'] = $form['expected_end_date'];
			$draft->save();

			$successMessage = "Task Create Successfully";
			if($form['assign_to_employee']){
				$draft->assign($form['assign_to_employee']);
				$successMessage = "Task Create and Assing Successfully";
			}
			
			$form->js(null,$form->js()->univ()->successMessage($successMessage))->reload()->execute();

        });

		//RUNNING AND PROCESSING TASK
		$right_col->add('View_Hint')->set('Running Task - Processing by Me');
		$mytask = $right_col->add('xProduction/Model_Task_Processing');
		$mytask->addCondition('employee_id',$this->api->current_employee->id);
		
		$crud=$right_col->add('CRUD',array('allow_add'=>false,'allow_edit'=>false,'allow_del'=>false,'grid_class'=>'xProduction/Grid_Task'));
		$crud->setModel($mytask);
		$crud->manageAction('mark_processed');
		$crud->manageAction('reject');
		$crud->manageAction('activities');


		$this->add('View_Warning')->set('Recent Activity On Task Assigned by You');
		

	}


	// function defaultTemplate(){
	// 	$this->app->pathfinder->base_location->addRelativeLocation(
	// 	    'epan-components/xProduction', array(
	// 	        'php'=>'lib',
	// 	        'template'=>'templates',
	// 	        'css'=>'templates/css',
	// 	        'js'=>'templates/js',
	// 	    )
	// 	);
	// 	return array('view/xepan-taskshortmenu');
	// }

}