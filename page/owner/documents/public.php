<?php

class page_owner_documents_public extends page_base_owner{
	function init(){
		parent::init();

		$this->add('View_Success')->set('Public Document');
		$model=$this->add('Model_Document_PublicDocument');
		$crud=$this->add('CRUD',array('grid_class'=>'Grid_GenericDocument'));
		$crud->setModel($model);
		$crud->manageAction('manage_attachments');
		$crud->manageAction('see_activities');

	}
}