<?php

class page_xHR_page_owner_department_post extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small>  Posts </small>');
		$dept_id= $this->api->stickyGET('department_id');
		$dept=$this->add('xHR/Model_Department')->load($dept_id);
		
		$post=$this->add('xHR/Model_Post');
		$post->addCondition('department_id',$_GET['department_id']);

		$crud=$this->add('CRUD');
		$crud->setModel($post);

		if(!$crud->isEditing()){
			$crud->grid->addFormatter('name','grid/inline');
			$g=$crud->grid;
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));
		
		}

		$p=$crud->addFrame('DocumentAcl',array('icon'=>'plus'));
		if($p){
			// create documentAcl rows for each docuemtn of the department if not exists
			$dept_docs = $dept->documents();
			foreach ($dept_docs as $doc) {
				$test = $this->add('xHR/Model_DocumentAcl');
				$test->addCondition('post_id',$crud->id);
				$test->addCondition('document_id',$doc->id);
				$test->tryLoadAny();
				if(!$test->loaded()) $test->save();
			}

			$post->load($crud->id);

			// documentAcl -> condition 'post_id'==crud->id
			$c = $p->add('CRUD',array('allow_add'=>false,'allow_del'=>false));
			$docs = $post->documentAcls();
			$c->setModel($docs);
			if($c->grid){
				$c->grid->addQuickSearch(array('Document'));
			}

			// if(!$c->isEditing()){
			// 	$c->grid->addFormatter('allow_add','grid/inline');
			// }

			// Document acl ka crud

		}

	}
}