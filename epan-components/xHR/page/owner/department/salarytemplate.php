<?php

class page_xHR_page_owner_department_salarytemplate extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small>  Salary Templates </small>');
		$col=$this->add('Columns');
			$salary_temp=$col->addColumn(6);
			$salary_temp_amount=$col->addColumn(6);

			$salarytem=$this->add('xHR/Model_SalaryTemplate');
			$crud=$salary_temp->add('CRUD');
				$crud->setModel($salarytem);
				$crud->addref('xHR/TemplateSalary',array('label'=>'Template Salary'));
			if(!$crud->isEditing()){
				$g=$crud->grid;
				$g->addPaginator(15);
				$g->addQuickSearch(array('name'));
			}

	}
}