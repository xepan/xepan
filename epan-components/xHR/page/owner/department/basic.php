<?php
class page_xHR_page_owner_department_basic extends Page{

	function init(){
		parent::init();

		if(!$_GET['department_id'])
			throw new \Exception($_GET['department_id']);
			
			// return;
		
		$this->api->stickyGET('department_id');
		$selected_dept_model = $this->add('xHR/Model_Department')->load($_GET['department_id']);		
		if(!$selected_dept_model->loaded())
			return;
		
		$form = $this->add('Form_Stacked');
		$form->setModel($selected_dept_model,array('previous_department_id','name','is_active','is_outsourced'));
		$form->addSubmit()->set('Update');

		$form->add('Controller_FormBeautifier');
		if($form->isSubmitted()){	
			$form->update();
			$form->js()->univ()->successMessage('Department Updtaed')->execute();
		}

	}
}