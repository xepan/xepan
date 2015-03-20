<?php

class page_xHR_page_owner_department_post extends page_xHR_page_owner_main {
	
	function init(){
		parent::init();

		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small>  Posts </small>');
		$dept_id= $this->api->stickyGET('hr_department_id');

		$dept=$this->add('xHR/Model_Department')->load($dept_id);
		
		$post=$this->add('xHR/Model_Post');
		$post->addCondition('department_id',$_GET['hr_department_id']);

		$post->addExpression('employees')->set($post->refSQL('xHR/Employee')->count());

		$crud=$this->add('CRUD');
		$crud->setModel($post,array('parent_post_id','name','is_active','can_create_team','test'),array('name','parent_post','is_active','can_create_team','employees'));

		if(!$crud->isEditing()){			
			$crud->grid->addFormatter('name','grid/inline');
			$g=$crud->grid;
			$g->addPaginator(15);
			$g->addQuickSearch(array('name'));

			// Employees Display under current Post
			$this->add('VirtualPage')->addColumn('Employees','Employees','Emp',$crud->grid)->set(function($p){
				$p->add('Grid')->addSno()->setModel('xHR/Model_Employee',array('name'))->addCondition('post_id',$p->id);
			});	

		}

		if($crud->isEditing()){
			$crud->virtual_page->getPage()->add('PageHelp',array('page'=>'department_add_post_form'));
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
			$fields=null;
			
			if($c->isEditing()){
				$doc_acl = $this->add('xHR/Model_DocumentAcl')->load($c->id);
				$document_editing = $this->add('xHR/Model_Document');
				$document_editing->load($doc_acl['document_id']);
				$original_model = $this->add($document_editing->modelName());
				if(isset($original_model->actions)){
					$fields=array_keys($original_model->actions);
				}
			}

			$c->setModel($docs,$fields,array('department','document','post','can_view'));

			if($c->isEditing()){
				if(isset($original_model->actions)){
					foreach ($original_model->actions as $field_name => $options) {
						if(is_array($options)){
							if(isset($options['caption'])) $c->form->getElement($field_name)->setCaption($options['caption']);
						}
					}
				}
			}


			if(!$c->isEditing()){
				$c->grid->addQuickSearch(array('Document'));
				$c->grid->addOrder()->move('edit','first')->now();
			}

			// Document acl ka crud
		}
	}
}