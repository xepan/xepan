<?php

class page_owner_documents_private extends page_base_owner{
	function init(){
		parent::init();

		$this->add('View_Success')->set('Private Document');

		$model=$this->add('Model_Document_PrivateDocument');
		$crud=$this->add('CRUD',array('grid_class'=>'Grid_GenericDocument'));
		$crud->setModel($model);
		// $crud->manageAction('manage_attachments');
		// $crud->manageAction('see_activities');
		$crud->manageAction('share');
	}
}