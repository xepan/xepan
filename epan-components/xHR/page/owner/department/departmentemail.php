<?php
class page_xHR_page_owner_department_departmentemail extends page_xHR_page_owner_main{

	function init(){
		parent::init();

		$dept_id= $this->api->stickyGET('hr_department_id');
		$dept=$this->add('xHR/Model_Department')->load($dept_id);

		$email=$this->add('xHR/Model_OfficialEmail');
		$email->addCondition('department_id',$dept_id);
		$email->getElement('employee_id')->system(true);

		if(!$dept->isCRM()){
			$email->getElement('is_support_email')->system(true);
			$email->getElement('auto_reply')->system(true);
			$email->getElement('email_subject')->system(true);
			$email->getElement('email_body')->system(true);
		}
		

		$crud=$this->add('CRUD',array('grid_class'=>'xHR/Grid_OfficialEmail'));
		$crud->setModel($email);
		
		if(!$crud->isEditing()){
			$g=$crud->grid;
			$g->removeColumn('item_name');
			$g->removeColumn('created_by');
			$g->removeColumn('employee');
			$g->removeColumn('email_password');
			$g->removeColumn('related_document');
		}

		if($crud->isEditing()){
			// $f = $crud->form;
			// $is_support_email_field=$f->getElement('is_support_email');
			// $is_support_email_field->js(true)->univ()
			// 	->bindConditionalShow(array(
			// 						""=>array(),
			// 						'true'=>array('auto_reply')
			// 					),'div .atk-form-row');
		}

		$crud->add('xHR/Controller_Acl');

	}
}