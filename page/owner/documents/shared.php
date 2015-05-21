<?php

class page_owner_documents_shared extends page_base_owner{
	function init(){
		parent::init();

		$this->add('View_Info')->set('Shared Document');

		$model=$this->add('Model_Document_SharedDocument');
		$crud=$this->add('CRUD',array('grid_class'=>'Grid_GenericDocument'));
		$crud->setModel($model);
		$crud->manageAction('manage_attachments');
		$crud->manageAction('see_activities');
	}
}