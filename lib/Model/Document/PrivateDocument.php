<?php

class Model_Document_PrivateDocument extends Model_GenericDocument {
	public $actions=array(
		'allow_add'=>array(),
		'allow_edit'=>array(),
		'allow_del'=>array()
		);

	function init(){
		parent::init();

		$this->addCondition('status','private');
		$this->addCondition('created_by_id',@$this->api->current_employee->id);
	}
}