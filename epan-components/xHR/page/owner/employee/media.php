<?php
class page_xHR_page_owner_employee_media extends Page{

	function init(){
		parent::init();

		if(!$_GET['employee_id'])
			// throw new \Exception($_GET['department_id']);
			
			return;
		
		$this->api->stickyGET('employee_id');
		$selected_dept_model = $this->add('xHR/Model_Employee')->load($_GET['employee_id']);		
		if(!$selected_dept_model->loaded())
			return;
		
		$form = $this->add('Form_Stacked');
		$form->setModel($selected_dept_model,array('empolyee_image_id'));
		$form->addSubmit('Update');

		// $form->add('Controller_FormBeautifier');
		if($form->isSubmitted()){	
			$form->update();
			$form->js()->univ()->successMessage(' Update Information')->execute();
		}

	}
}