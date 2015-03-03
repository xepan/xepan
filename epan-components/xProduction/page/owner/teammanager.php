<?php
class page_xProduction_page_owner_teammanager extends page_xProduction_page_owner_main{
	
	function init(){
		parent::init();
		
		$team=$this->add('xProduction/Model_Team');
		$team->addCondition('department_id',$this->api->current_employee->department()->get('id'));

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
		
		$emp->addExpression('is_team_leader')->set(function($m,$q)use($team_id){
			$t_emps = $m->add('xProduction/Model_EmployeeTeamAssociation',array('table_alias'=>'temp'));
			$t_emps->addCondition('team_id',$team_id);
			$t_emps->addCondition('is_team_leader',true);
			$t_emps->addCondition('employee_id',$q->getField('id'));

			return $t_emps->count();
		})->type('boolean');
		// selector form
		$form = $this->add('Form');
		$item_emp_field = $form->addField('hidden','team_employee')->set(json_encode($team->getAssociatedEmployees()));
		$form->addSubmit('Update');
	
		$grid->setModel($emp,array('name','is_team_leader'));
		$grid->addSelectable($item_emp_field);
		$grid->addColumn('Button','mark_team_leader');
		
		if($_GET['mark_team_leader']){			
			$item_emp_model=$this->add('xProduction/Model_EmployeeTeamAssociation');
			$item_emp_model->addCondition('team_id',$team_id);
			$item_emp_model->_dsql()->set('is_team_leader',0)->update();

			$item_emp_model=$this->add('xProduction/Model_EmployeeTeamAssociation');
			$item_emp_model->addCondition('employee_id',$_GET['mark_team_leader']);
			$item_emp_model->addCondition('team_id',$team_id);

			$item_emp_model['is_team_leader'] = true;
			$item_emp_model->save();
			$grid->js(null,$this->js()->univ()->successMessage('Team Leader Changes'))->reload()->execute();
		}

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