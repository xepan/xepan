<?php

class page_owner_documents extends page_base_owner{
	
	function init(){
		parent::init();

		$this->app->title='Company: Documents';
		$this->vp = $this->add('VirtualPage')->set(function($p){
			$document = $p->add('Model_GenericDocument')->load($_GET['document_searched']);
			$document_view = $p->add('View_Document');
			$document_view->setModel($document);
		});


		$document_model = $this->add('Model_GenericDocument');
		// $document_model->title_field = 'search_phrase';

		$cols = $this->app->layout->add('Columns',null,'page_title');
		$lc= $cols->addColumn(8);
		$rc= $cols->addColumn(4);
		$lc->add('View')->setHTML('<i class="fa fa-users"></i>Company :: Documents  <small>Public / Departmental / Shared / Personal </small>');
		$form = $rc->add('Form_Empty');
		$form->addField('autocomplete/Basic','document')->setModel($document_model);

		if($form->isSubmitted()){
			$document_model->load($form['document']);

			$form->js(null, $form->js()->reload())->univ()->frameURL('Documents'."  " . $document_model['name'],$this->api->url($this->vp->getURL(),array('document_searched'=>$form['document'])))->execute();
		}
		// $doc_m= $this->add('Model_GenericDocument');
		// $crud = $this->add('CRUD',array('grid_class'=>'Grid_GenericDocument'));
		// $crud->setModel($doc_m);
		// $crud->add('xHR\Controller_Acl');

		// $this->add('Model_GenericDocumentShare'); // Just to reproduce Table with dynamic line if change

		$tabs=$this->add('Tabs');
		$tabs->addTabURL('owner/documents_public','Public');
		$tabs->addTabURL('owner/documents_department','Departmental');
		$tabs->addTabURL('owner/documents_shared','Shared With Me');
		$tabs->addTabURL('owner/documents_private','Private');
		
	}
}