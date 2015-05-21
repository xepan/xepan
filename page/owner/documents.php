<?php

class page_owner_documents extends page_base_owner{
	
	function init(){
		parent::init();

		$this->app->title='Company: Documents';
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-files-o"></i> Company :: Documents  <small>Public / Departmental / Shared / Personal </small>' );

		$doc_m= $this->add('Model_GenericDocument');

		$crud = $this->add('CRUD',array('grid_class'=>'Grid_GenericDocument'));
		$crud->setModel($doc_m);

		$crud->add('xHR\Controller_Acl');
		
	}
}