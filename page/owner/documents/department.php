<?php

class page_owner_documents_department extends page_base_owner{
	function init(){
		parent::init();

		$this->add('View_Warning')->set('Department Document');

		$model=$this->add('Model_Document_DepartmentDocument');
		$crud=$this->add('CRUD',array('grid_class'=>'Grid_GenericDocument'));
		$crud->setModel($model);
		$crud->manageAction('manage_attachments');
		$crud->manageAction('see_activities');

	}
}