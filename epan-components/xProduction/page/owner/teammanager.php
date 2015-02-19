<?php
class page_xProduction_page_owner_teammanager extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		$team=$this->add('xProduction/Model_Team');
		
		$crud=$this->app->layout->add('CRUD');
		$crud->setModel($team);
		if($g=$crud->grid){
			$g->addColumn('Expander','team_members');
		}
	}


	function page_team_members(){
		$team_id = $this->api->stickyGET('xproduction_teams_id');
		$team=$this->add('xProduction/Model_Team');
		$team->load($team_id);

		$department_employees = $this->api->current_employee->department()->employees();

		$grid=$this->add('Grid');
		$emp = $this->add($department_employees);

		// selector form
		$form = $this->add('Form');
		$item_emp_field = $form->addField('hidden','team_employee')->set(json_encode($team->getAssociatedEmployees()));
		$form->addSubmit('Update');
	
		$grid->setModel($emp,array('name'));
		$grid->addSelectable($item_emp_field);

		if($form->isSubmitted()){
			$selected_emp = json_decode($form['team_employee'],true);
			
			foreach ($department_employees as $dept_emp) {
				if(in_array($dept_emp->id,$selected_emp))
					$team->addEmployee($dept_emp);
				else
					$team->removeEmployee($dept_emp);
			}

			$form->js(null,$this->js()->univ()->successMessage('Updated'))->reload()->execute();
		}		
		$grid->addQuickSearch(array('name'));
		$grid->addPaginator($ipp=100);
	}
}