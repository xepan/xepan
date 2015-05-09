<?php

class page_xHR_page_owner_department_salarytemplate extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small>  Salary Templates </small>');

		$salarytem=$this->add('xHR/Model_SalaryTemplate');
		$salarytem->addCondition('department_id',$this->api->stickyGET('hr_department_id'));


		$crud=$this->add('CRUD');
		$crud->setModel($salarytem,array('post_id','name'),array('post','name'));
		$tsc = $crud->addref('xHR/TemplateSalary',array('label'=>'Template Salary'));

		if(!$crud->isEditing()){
			$g=$crud->grid;
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));
		}

		if($crud->isEditing()){
			// $crud->form->getElement('post_id')->getModel()->addCondition('department_id',$_GET['hr_department_id']);
		}
	}
}