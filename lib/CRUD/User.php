<?php

class CRUD_User extends CRUD{

	public $app_page=null;
	public $option_page=null;
	public $config_page=null;

	function init(){
		parent::init();

		if(!$this->isEditing()){
			$this->grid->addQuickSearch(array('name','username','email'));
			$this->grid->addPaginator(100);
			$this->grid->add_sno();
		}
	}

	function recursiveRender(){

		$this->addOptions();
		$this->addCustomFieldsOptions();
		$this->addAppAccessOptions();
			
		if(!$this->isEditing()){
			$this->grid->addMethod('format_delete2',function($g,$f){
				if($g->model->isDefaultSuperUser()){
					$g->current_row_html['delete']="";
				}
			});

			$this->grid->addFormatter('delete','delete2');

			$this->grid->addMethod('format_edit2',function($g,$f){
				if($g->model->isDefaultSuperUser() and !$g->model->isMe()){
					$g->current_row_html['edit']="";
				}
			});

			$this->grid->addFormatter('edit','edit2');

		}

		parent::recursiveRender();
	}

	function setModel($model,$field_form=null,$field_grid=null){
		if($this->isEditing()){
			if($model->load($this->id)->isDefaultSuperUser()){
				$model->getElement('type')->display(array('form'=>'Readonly'));
				$model->getElement('is_active')->system(true);
				$model->getElement('user_management')->system(true);
				$model->getElement('general_settings')->system(true);
				$model->getElement('application_management')->system(true);
				$model->getElement('website_designing')->system(true);
			}
		}
		$m = parent::setModel($model,$field_form,$field_grid);

		return $this->model;
	}

	function addOptions(){
		if(!$this->isEditing()){
			$op_btn = $this->grid->addButton(array('Options','icon'=>'cog'));
			$op_btn->js('click',$this->js()->univ()->frameURL('User Options',$this->option_page));
		}
	}

	function addCustomFieldsOptions(){
		if(!$this->isEditing()){
			$cust_btn = $this->grid->addButton('User Custom Fields');
			$cust_btn->setIcon('ui-icon-wrench');
			$cust_btn->js('click',$this->js()->univ()->frameURL('User Custom Fields ',$this->config_page));
		}
	}


	function addAppAccessOptions(){
		if(!$this->isEditing()){
			$this->grid->addMethod('format_app_permission',function($g,$f){
				if($g->model->isFrontEndUser() or $g->model->isDefaultSuperUser()){
					$g->current_row_html['application_permissions']="";
				}
			});

			$this->grid->addColumn('Expander,app_permission','application_permissions',array('page'=>$this->app_page,'descr'=>'App'));
		}else{
			if($this->model->isFrontEndUser()){
				$this->form->getElement('user_management')->destroy();
				$this->form->getElement('general_settings')->destroy();
				$this->form->getElement('application_management')->destroy();
				$this->form->getElement('website_designing')->destroy();
			}
		}
	}

	
}