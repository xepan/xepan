<?php

class Model_Document_DepartmentDocument extends Model_GenericDocument {
	public $actions=array(
		'allow_add'=>array(),
		'allow_edit'=>array(),
		'allow_del'=>array(),
		);

	function init(){
		parent::init();
		$this->addCondition('status','departmental');
	}
}