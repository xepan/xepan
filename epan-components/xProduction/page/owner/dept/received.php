<?php

class page_xProduction_page_owner_dept_received extends page_xProduction_page_owner_dept_base{
	
	function init(){
		parent::init();
		

		$received_jobcard_model=$this->add('xProduction/Model_Jobcard_Received');

		if($this->api->stickyGET('department_id'))
			$received_jobcard_model->addCondition('to_department_id',$_GET['department_id']);

		$crud=$this->add('CRUD',array('grid_class'=>'xProduction/Grid_JobCard'));
		$crud->setModel($received_jobcard_model);
		$p=$crud->addFrame('Details', array('icon'=>'plus'));
		if($p){
			$p->add('xProduction/View_Jobcard',array('jobcard'=>$this->add('xProduction/Model_JobCard')->load($crud->id)));
		}
		$crud->add('xHR/Controller_Acl');

	


		// $p=$crud->addFrame('assign',array('label'=>'label','title'=>'title','descr'=>'descr'));
		

		// if($p){
		// 	// Job Assign Management
		// 	$received_jobcard_model->load($crud->id);

		// 	if($this->app->current_employee->department()->loaded())
		// 		$employee_model = $this->app->current_employee->department()->employees();
		// 	else
		// 		$employee_model = $this->add('xHR/Model_Employee');

		// 	$employee_grid = $p->add('Grid');
		// 	$employee_grid->setModel($employee_model);

		// 	$form = $p->add('Form');
		// 	$employee_field = $form->addField('hidden','employee_selected');

		// 	$employee_field->set(json_encode($received_jobcard_model->getAssociatedEmployees()));
		// 	$employee_grid->addSelectable($employee_field);

		// 	$form->addSubmit();
			
		// 	if($form->isSubmitted()){
		// 		$this_job_card = $this->add('xProduction/Model_Jobcard_Received')
		// 			->load($crud->id);

		// 		$this_job_card->removeAllEmployees();

		// 		$employee_selected = $form['employee_selected'];
		// 		$employee_selected = json_decode($employee_selected,true);
		// 		foreach ($employee_selected as $emp_id) {
		// 			$this_job_card->assignTo($this->add('xHR/Model_Employee')->load($emp_id));
		// 		}
		// 		$form->js()->univ()->closeDialog()->execute();
		// 	}
		// }

	}
}