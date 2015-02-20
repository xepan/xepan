<?php
class page_xHR_page_owner_department_outsource extends Page{

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
		$form->setModel($selected_dept_model,array('is_outsourced',
												   'maintain_stock'));
		$form->addSubmit()->set('Update');

		if($selected_dept_model['is_outsourced']){
			$crud=$this->add('CRUD');
			$crud->setModel('xHR/Model_OutSourceParty');
		}

		$form->add('Controller_FormBeautifier');
		if($form->isSubmitted()){	
			$form->update();
			$this->js()->univ()->successMessage('Department Updtaed')->reload()->execute();
		}

	}
}