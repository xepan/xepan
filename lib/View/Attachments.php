<?php


class View_Attachments extends View{
	public $root_document_name="";

	function init(){
		parent::init();

		if($this->root_document_name ==""){
			throw new \Exception("root Document Name must name must be defined");
		}

		$this->api->stickyGET('id');
		$this->api->stickyGET('department_id');

		
		$crud = $this->add('CRUD');
		$crud->setModel($document->ref('Attachments'));
		$crud->add('Controller_ACL');
	}

}