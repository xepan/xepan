<?php

class page_xHR_page_owner_employee_department extends Page{
	function init(){
		parent::init();

		$employee_id = $this->api->stickyGET('employee_id');
		$employee = $this->add('xHR/Model_Employee')->load($employee_id);

		$col=$this->add('Columns');
		$dept_col=$col->addColumn(4);
		$post_col=$col->addColumn(8);
		
		$department = $this->add('xHR/Model_Department');
		$post = $this->add('xHR/Model_Post');
		if($_GET['department_selecetd']){
			$post->addCondition('department_id',$_GET['department_selecetd']);
		}else{
			// $post->addCondition('department_id',-1);
		}
		
		$form=$dept_col->add('Form');
			$department_field=$form->addField('DropDownNormal','department')->setEmptyText('Please Select department')->validateNotNull(true);
				$department_field->setModel($department);
				$department_field->set($employee->department()->get('id'));
			
			$post_field=$form->addField('DropDownNormal','post')->setEmptyText('Please Select post')->validateNotNull(true);
				$post_field->setModel($post);
				$post_field->set($employee->post()->get('id'));

			$department_field->js('change',$form->js()->atk4_form('reloadField','post',array($this->api->url(),'department_selecetd'=>$department_field->js()->val())));


		$form->addSubmit('Update');

		if($form->isSubmitted()){	
			$employee['department_id'] = $form['department'];
			$employee['post_id'] = $form['post'];
			$employee->save();
			$form->js(null,$form->js()->_selector('.xemployee_box')->trigger('reload'))->reload()->univ()->successMessage(' Update Information')->execute();
			// $form->js()->univ()->successMessage(' Update Information')->execute();
		}
		
		$salary_template_model=$this->add('xHR/Model_SalaryTemplate');
		$salary_template_model->addCondition('department_id',$employee['department_id']);

		$salary_form=$post_col->add('Form');
			$temp_field=$salary_form->addField('DropDownNormal','salary_template');
			$temp_field->setModel($salary_template_model);
			$salary_form->addSubmit('Copy Template');
		
		$salary_model=$this->add('xHR/Model_Salary');
		$salary_model->addCondition('employee_id',$employee_id);
		$salary_crud=$post_col->add('CRUD');
			$salary_crud->setModel($salary_model);


		if($salary_form->isSubmitted()){
			$employee->removeAllSalary();
			$salary_template_model->load($salary_form['salary_template']);
			$salaries_in_template = $salary_template_model->ref('xHR/TemplateSalary');
				foreach ($salaries_in_template as $st) {
					$employee->addSalary($st->ref('salary_type_id'),$st['amount']);
				}
			
			$salary_form->js(null,$salary_crud->js()->reload())->univ()->successMessage(' Copy Success')->execute();
		}
	}
}